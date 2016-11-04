<?php


class AitLanguages
{

	public static function before()
	{
		static::maybeAddDefaultOptions();
		static::maybeUpdateOptionsFor20();
		static::loadPluginsTextdomains();
	}



	public static function after()
	{
		static::modifyLanguageList();
		static::loadAitThemeTextdomain();
		static::adminBarLanguageSwitcher();
		static::adminMenu();
		static::enqueueAssets();
		static::afterDemoContentImport();
		static::clearThemeCache();
		static::migrateTo20();
		static::handleUserLang();
	}



	public static function maybeUpdateOptionsFor20()
	{
		$options = get_option('polylang', array());
		if(!empty($options['version']) and version_compare($options['version'], '1.4-dev', '<=')){
			update_option('polylang_13x', $options); // backup old options just for case

			// Change some default settings of polylang, they are needed for WooPoly corect behaviour
			$options['force_lang'] = 1;

			// Add WooCommerce CPTs and Tax
			if(!in_array('product', $options['post_types'])){
				$options['post_types'][] = 'product';
			}

			if(!in_array('product_cat', $options['taxonomies'])){
				$options['taxonomies'][] = 'product_cat';
			}

			if(!in_array('product_tag', $options['taxonomies'])){
				$options['taxonomies'][] = 'product_tag';
			}

			if(!in_array('product_shipping_class', $options['taxonomies'])){
				$options['taxonomies'][] = 'product_shipping_class';
			}

			$options['post_types'] = array_unique($options['post_types']);
			$options['taxonomies'] = array_unique($options['taxonomies']);

			update_option('polylang', $options);
			update_option('_ait-languages_should_migrate', 'yes');
		}
	}



	protected static function loadPluginsTextdomains()
	{
		add_action('plugins_loaded', function(){

			$plugins = wp_get_active_and_valid_plugins();
			$network_plugins = is_multisite() ? wp_get_active_network_plugins() : array();

			$all_active_plugins = array_merge($plugins, $network_plugins);

			$locale = get_locale();

			foreach($all_active_plugins as $plugin){
				$basename = plugin_basename($plugin);
				$slug = dirname($basename);
				if((strncmp($slug, "ait-", 4) === 0 and $slug != 'ait-languages') or $slug === 'revslider'){ // startsWith
					load_plugin_textdomain($slug, false, "$slug/languages"); // can be in wp-content/languages/plugins/{$slug}
					load_textdomain($slug, POLYLANG_DIR . "/ait/languages/{$slug}/{$slug}-{$locale}.mo");
				}
			}
		}, 1);
	}



	protected static function loadAitThemeTextdomain()
	{
		add_action('ait-after-framework-load', function(){
			global $locale;
			$currentTheme = get_stylesheet();

			if(defined('PLL_ADMIN') and PLL_ADMIN){
				$maybeFilteredLocale = apply_filters('theme_locale', get_locale(), 'ait-admin');
				if(!$maybeFilteredLocale){
					$maybeFilteredLocale = $locale;
				}
				if($themeAdminOverrideFile = aitPath('languages', "/admin-{$maybeFilteredLocale}.mo")){
					load_textdomain('ait-admin', $themeAdminOverrideFile);
				}
				load_textdomain('ait-admin', WP_LANG_DIR . "/themes/{$currentTheme}-admin-{$locale}.mo");
				load_textdomain('ait-admin', POLYLANG_DIR . "/ait/languages/ait-theme/admin-{$maybeFilteredLocale}.mo");
			}else{
				$maybeFilteredLocale = apply_filters('theme_locale', get_locale(), 'ait');
				if(!$maybeFilteredLocale){
					$maybeFilteredLocale = $locale;
				}
				if($themeOverrideFile = aitPath('languages', "/{$maybeFilteredLocale}.mo")){
					load_textdomain('ait', $themeOverrideFile);
				}
				load_textdomain('ait', WP_LANG_DIR . "/themes/{$currentTheme}-{$locale}.mo");
				load_textdomain('ait', POLYLANG_DIR . "/ait/languages/ait-theme/{$maybeFilteredLocale}.mo");
			}
		});
	}



	protected static function modifyLanguageList()
	{
		add_filter('pll_predefined_languages', function($languages){
			$supportedByAit = apply_filters('ait-supported-languages', array(
				'bg_BG',
				'cs_CZ',
				'de_DE',
				'el',
				'en_US',
				'es_ES',
				'fi',
				'fr_FR',
				'hi_IN',
				'hr',
				'hu_HU',
				'id_ID',
				'it_IT',
				'nl_NL',
				'pl_PL',
				'pt_BR',
				'pt_PT',
				'ro_RO',
				'ru_RU',
				'sk_SK',
				'sq',
				'sv_SE',
				'tr_TR',
				'uk',
				'zh_CN',
				'zh_TW',
			));
			foreach($languages as $i => $lang){
				if(!in_array($lang[1], $supportedByAit)){
					unset($languages[$i]);
				}
				if($lang[1] == 'zh_CN'){
					$languages[$i][0] = 'cn';
				}
				if($lang[1] == 'zh_TW'){
					$languages[$i][0] = 'tw';
				}
				if($lang[1] == 'pt_BR'){
					$languages[$i][0] = 'br';
				}
			}
			return $languages;
		});
	}



	protected static function maybeAddDefaultOptions()
	{
		add_filter('pre_update_option_polylang', function($options, $oldOptions){

			// when plugin is activated for the first time - it does not have any options yet in DB
			if(empty($oldOptions)){

				// Add all translatable AIT CPTs and WooCommerce CPTs to options
				if(class_exists('AitToolkit')){

					$aitCpts = AitToolkit::getManager('cpts')->getTranslatable('list');
					// $options['poyst_types'] contains all non-builtin public CPTs
					foreach($options['post_types'] as $i => $cpt){
						if(substr($cpt, 0, 4) === 'ait-'){
							if(!in_array($cpt, $aitCpts)){
								unset($options['post_types'][$i]); // unset all AIT non-translatable CPTs if they are set
							}
						}
					}
					$options['post_types'] = array_unique(array_merge($options['post_types'], $aitCpts)); // add translatable AIT CPTs

					$pllTaxs = $options['taxonomies'];
					$aitCpts = AitToolkit::getManager('cpts')->getAll();

					$aitTaxs = array();
					foreach($aitCpts as $cpt){
						$aitTaxs = array_merge($aitTaxs, $cpt->getTranslatableTaxonomyList());
					}

					foreach($pllTaxs as $i => $tax){
						if(substr($tax, 0, 4) === 'ait-'){
							if(!in_array($tax, $aitTaxs)){
								unset($options['taxonomies'][$i]);
							}
						}
					}
					$options['taxonomies'] = array_unique(array_merge($options['taxonomies'], $aitTaxs));
				}

				// Change some default settings of polylang, they are needed for WooPoly corect behaviour
				$options['browser'] = 0;
				$options['hide_default'] = 1;
				$options['force_lang'] = 1;
			}

			return $options;

		}, 10, 2);
	}



	protected static function adminBarLanguageSwitcher()
	{
		add_action('admin_bar_menu', function($wp_admin_bar){
			global $polylang;

			if(!is_admin()) return;

			$currentLang = $polylang->model->get_language(get_locale());

			if(!$currentLang){
				$currentLang = isset($polylang->options['default_lang']) && ($lang = $polylang->model->get_language($polylang->options['default_lang'])) ? $lang : false;
			}

			if(!$currentLang) return;

			$wp_admin_bar->add_node(array(
				'id' => 'ait-admin-languages-switcher',
				'title'  =>  empty($currentLang->flag) ? esc_html(sprintf(__('Admin Language: %s', 'ait-languages'), $currentLang->name)) : sprintf(__('Admin Language: %s %s', 'ait-languages'), $currentLang->flag, esc_html($currentLang->name)),
				'parent' => 'top-secondary',
				'href' => '#',
			));

			foreach ($polylang->model->get_languages_list() as $lang){
				if ($currentLang->slug == $lang->slug) continue;

				$wp_admin_bar->add_menu(array(
					'parent' => 'ait-admin-languages-switcher',
					'id'     => "ait-lang-{$lang->slug}",
					'title'  => empty($lang->flag) ? esc_html($lang->name) : $lang->flag .'&nbsp;'. esc_html($lang->name),
					'href'   => '#',
					'meta' => array('class' => "ait-admin-lang {$lang->locale}"),
				));
			}
		}, 2014);

		static::ajaxSwitchUserLang();
		static::userLangSwitcherScript();
	}



	protected static function ajaxSwitchUserLang()
	{
		add_action('wp_ajax_switch_user_lang', function(){
			global $polylang;
			if(PLL_ADMIN){
				$polylang->filters->personal_options_update(get_current_user_id());
			}
		});
	}



	protected static function userLangSwitcherScript()
	{
		add_action('admin_head', function(){
			global $polylang;
			if(is_admin_bar_showing() and $polylang->model->get_languages_list()){
				$ajaxUrl = admin_url('admin-ajax.php');
				?>
				<script>
				jQuery(function($){
					$('#wp-admin-bar-ait-admin-languages-switcher li.ait-admin-lang').on('click', function(){
						var lang = 'en_US';
						var classes = jQuery(this).attr('class').split(/\s+/);
						if(classes.length == 2 ){
							lang = classes[1];
						}
						$.post('<?php echo $ajaxUrl ?>', {'action': 'switch_user_lang', 'user_lang': lang}, function(response){
							window.location.reload();
						});
					});
				});
				</script>
				<?php
			}
		});
	}



	protected static function adminMenu()
	{
		add_action('admin_menu', function(){
			if(current_theme_supports('ait-languages-plugin') and function_exists('aitConfig')){
				global $polylang;

				if(empty($polylang)) return;

				remove_submenu_page('options-general.php', 'mlang');

				$defaultPage = aitConfig()->getDefaultAdminPage();
				add_submenu_page(
					"ait-{$defaultPage['slug']}",
					__('Languages', 'ait-languages'),
					__('Languages', 'ait-languages'),
					'manage_options',
					'mlang',
					array($polylang->settings_page, 'languages_page')
				);
			}
		}, 20);
	}



	protected static function enqueueAssets()
	{
		add_action('plugins_loaded', function(){
			global $polylang;

			remove_action('admin_enqueue_scripts', array($polylang, 'admin_enqueue_scripts'));

			add_action('admin_enqueue_scripts', function() use($polylang) {

				// copy&paste PLL_Admin::admin_enqueue_scripts()

				$screen = get_current_screen();

				if (empty($screen))
					return;

				$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

				// for each script:
				// 0 => the pages on which to load the script
				// 1 => the scripts it needs to work
				// 2 => 1 if loaded even if languages have not been defined yet, 0 otherwise
				// 3 => 1 if loaded in footer
				// FIXME: check if I can load more scripts in footer
				$scripts = array(
					'admin' => array( array('settings_page_mlang'), array('jquery', 'wp-ajax-response', 'postbox'), 1 , 0),
					'post'  => array( array('post', 'media', 'async-upload', 'edit'),  array('jquery', 'wp-ajax-response', 'post', 'jquery-ui-autocomplete'), 0 , 1),
					'media' => array( array('upload'), array('jquery'), 0 , 1),
					'term'  => array( array('edit-tags', 'term'), array('jquery', 'wp-ajax-response', 'jquery-ui-autocomplete'), 0, 1),
					'user'  => array( array('profile', 'user-edit'), array('jquery'), 0 , 0),
				);

				foreach ($scripts as $script => $v)
					if ((in_array($screen->base, $v[0]) or strpos($screen->base, '_mlang') !== false) && ($v[2] || $polylang->model->get_languages_list()))
						wp_enqueue_script('pll_'.$script, POLYLANG_URL .'/js/'.$script.$suffix.'.js', $v[1], POLYLANG_VERSION, $v[3]);

				wp_enqueue_style('polylang_admin', POLYLANG_URL .'/css/admin'.$suffix.'.css', array(), POLYLANG_VERSION);
			});
		});

		add_action('admin_head', function(){
			$screen = get_current_screen();
			if(empty($screen)) return;

			if(strpos($screen->base, '_mlang') !== false){
				// make lang_locale input read-only, it can cuase more demage then it is usefull for simple users
				// hide rtl radios, we do not support rtl languages for now
				?>
				<script>
					jQuery(function(){
						var $langLocale = jQuery('#lang_locale');
						if($langLocale.length){
							$langLocale.attr('readonly', true);
						}
						var $rtl = jQuery('input[name="rtl"]').closest('div.form-field');
						if($rtl.length){
							$rtl.css('display', 'none');
						}
					});
				</script>
				<?php if(apply_filters('ait_languages_enable_url_settings', false)): ?>
				<style>
					form#options-lang table.form-table tr.hidden {
						display: table-row;
					}
				</style>
				<?php endif ?>
				<?php
			}

		}, 20);
	}



	protected static function afterDemoContentImport()
	{
		add_action('ait-after-import', function($whatToImport, $results = ''){
			delete_transient('pll_languages_list');
		}, 10, 2);
	}



	protected static function clearThemeCache()
	{
		$c = __CLASS__;
		add_action('updated_user_meta', function($meta_id, $user_id, $meta_key, $_meta_value) use($c){
			if($meta_key === 'user_lang'){
				$c::clearCacheByUserId();
			}
		}, 10, 4);

		add_action('delete_transient_pll_languages_list', function(){
			if(class_exists('AitCache')){
				AitCache::clean();
			}
		});

		register_activation_hook(POLYLANG_BASENAME, array(__CLASS__, 'clearCacheByUserId'));
		register_deactivation_hook(POLYLANG_BASENAME, array(__CLASS__, 'clearCacheByUserId'));
	}



	protected static function shouldMigrate()
	{
		return (get_option('_ait-languages_should_migrate', 'no') === 'yes');
	}



	protected static function migrateTo20()
	{
		if(static::shouldMigrate()){
			add_action('wp_loaded', function(){
					if(defined('DOING_AJAX') and DOING_AJAX) return;
					flush_rewrite_rules(true);
			}, 15);

			add_action('admin_init', function(){
				if(defined('DOING_AJAX') and DOING_AJAX) return;
				$options = get_option('polylang');
				$adminModel = new PLL_Admin_Model($options);
				if($nolang = $adminModel->get_objects_with_no_lang() and isset($options['default_lang'])){
					if(!empty($nolang['posts'])){
						$adminModel->set_language_in_mass('post', $nolang['posts'], $options['default_lang']);
					}
					if(!empty($nolang['terms'])){
						$adminModel->set_language_in_mass('term', $nolang['terms'], $options['default_lang']);
					}
				}
				unset($adminModel);
				delete_option('_ait-languages_should_migrate');
			}, 15);
		}
	}



	public static function clearCacheByUserId()
	{
		if(class_exists('AitCache')){
			$user_id = get_current_user_id();
			AitCache::remove("@raw-config-$user_id");
			AitCache::remove("@processed-config-$user_id");
		}
	}



	protected static function handleUserLang()
	{
		add_filter("delete_user_metadata", function($null, $object_id, $meta_key, $meta_value, $delete_all){
			global $polylang;

			if($meta_key === 'user_lang'){
				if($locales = $polylang->model->get_languages_list(array('fields' => 'locale'))){
					$locale = get_option('WPLANG', 'en_US');
					foreach($locales as $l){
						if($l !== $meta_value){
							$locale = $l;
							break;
						}
					}
					update_user_meta(get_current_user_id(), 'user_lang', $locale);
					return $locale;
				}
			}
			return $null;
		}, 10, 5);
	}
}


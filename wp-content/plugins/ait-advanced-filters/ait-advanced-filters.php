<?php

/*
 * AIT WordPress Plugin
 *
 * Copyright (c) 2014, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */

/*
Plugin Name: AIT Advanced Filters
Plugin URI: http://ait-themes.club
Description: Adds advanced content filtering for CityGuide theme
Version: 1.16
Author: AitThemes.Club
Author URI: http://ait-themes.club
Text Domain: ait-advanced-filters
Domain Path: /languages
License: GPLv2 or later
*/

/* trunk@r152 */

define('AIT_ADVANCED_FILTERS_ENABLED', true);

AitAdvancedFilters::init();

class AitAdvancedFilters {

	protected static $currentTheme;
	protected static $paths;

	public static function init(){

		self::$currentTheme = sanitize_key(get_stylesheet());

		self::$paths = array(
			'config' => dirname( __FILE__ ).'/config',
			'templates' => dirname( __FILE__ ).'/templates',
		);

		register_activation_hook( __FILE__, array(__CLASS__, 'onActivation') );
		register_deactivation_hook(  __FILE__, array(__CLASS__, 'onDeactivation') );

		add_action('init', array(__CLASS__, 'onInit'));
		add_action('plugins_loaded', array(__CLASS__, 'onLoaded'));

		// Item Actions
		add_filter("manage_ait-item_posts_columns", array(__CLASS__, 'filtersManageColumns'));

		// Category Actions / Custom Fields
		add_action('ait-items_filters_add_form_fields', array(__CLASS__, 'filtersAddFormFields'), 10, 2);
		add_action('ait-items_filters_edit_form_fields', array(__CLASS__, 'filtersEditFormFields'), 10, 2);
		add_action("edited_ait-items_filters", array(__CLASS__, 'filtersSaveFormFields'), 10, 2);
		add_action("created_ait-items_filters", array(__CLASS__, 'filtersSaveFormFields'), 10, 2);
		add_filter('manage_edit-ait-items_filters_columns', array(__CLASS__, 'filtersTaxonomyColumns'), 12, 1);
		add_filter('ait-items_filters_row_actions', array(__CLASS__, 'filtersTaxonomyRowActions'), 10, 2);

		add_action('init', array(__CLASS__, 'addItemMetaboxOptions'), 12, 0);
		add_action('admin_menu' , array(__CLASS__, 'removeDefaultTagsMetabox'));

		// Templates
		add_filter('wplatte-get-template-part', array(__CLASS__, 'getTemplates'), 10, 3);

		// Scripts, Styles, etc
		add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueueFrontendScripts') );
		add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueAdminScripts') );

		add_filter('ait-special-custom-pages', array(__CLASS__, 'removeCustomTaxonomiesFromSpecialPages'), 15);
	}

	public static function onActivation(){
		flush_rewrite_rules();

		AitAdvancedFilters::updateThemeOptions();
		AitCache::clean();
	}

	public static function onDeactivation(){
		flush_rewrite_rules();
	}

	public static function onInit(){
		AitAdvancedFilters::registerTax();

		AitAdvancedFilters::registerAdminCapabilities();
	}

	public static function onLoaded(){
		load_plugin_textdomain('ait-advanced-filters', false,  dirname(plugin_basename(__FILE__ )) . '/languages');

		add_filter('ait-theme-config', array('AitAdvancedFilters', 'prepareThemeConfig'));
	}

	/* WORDPRESS CONFIGURATION */
	public static function loadPluginConfig($type = 'raw'){
		$config = include self::$paths['config'].'/theme-options.php';
		return $config[$type];
	}

	public static function prepareThemeConfig($config = array()){
		$plugin = AitAdvancedFilters::loadPluginConfig();

		if(count($config) == 0){
			$theme = self::$currentTheme;
			$config = get_option("_ait_{$theme}_theme_opts", array());
			$plugin = AitAdvancedFilters::loadPluginConfig('defaults');
		}

		return array_merge($config, $plugin);
	}

	public static function updateThemeOptions(){
		// check if the settings already exists
		$theme = self::$currentTheme;
		$themeOptions = get_option("_ait_{$theme}_theme_opts");
		if(!isset($themeOptions['itemAdvancedFilters'])){
			$updatedConfig = AitAdvancedFilters::prepareThemeConfig();
			$theme = self::$currentTheme;
			update_option("_ait_{$theme}_theme_opts", $updatedConfig);
		}
	}
	/* WORDPRESS CONFIGURATION */

    public static function removeCustomTaxonomiesFromSpecialPages($specialPages)
    {
        unset($specialPages['_taxonomy_ait-items_filters']);
        return $specialPages;
    }

	/* TYPE REGISTRATION */
	public static function registerTax(){
		$labels = array(
			'name'				=> _x( 'Advanced Filters', 'taxonomy general name', 'ait-advanced-filters' ),
			'singular_name'		=> _x( 'Advanced Filter', 'taxonomy singular name', 'ait-advanced-filters' ),
			'search_items'		=> __( 'Search Filters', 'ait-advanced-filters' ),
			'all_items'			=> __( 'All Filters', 'ait-advanced-filters' ),
			'parent_item'		=> __( 'Parent Filter', 'ait-advanced-filters' ),
			'parent_item_colon'	=> __( 'Parent Filter:', 'ait-advanced-filters' ),
			'edit_item'			=> __( 'Edit Filter', 'ait-advanced-filters' ),
			'update_item'		=> __( 'Update Filter', 'ait-advanced-filters' ),
			'add_new_item'		=> __( 'Add New Filter', 'ait-advanced-filters' ),
			'new_item_name'		=> __( 'New Filter Name', 'ait-advanced-filters' ),
			'menu_name'			=> __( 'Item Filters', 'ait-advanced-filters' ),
		);

		$capabilities = array(
			'manage_terms'		=> "ait_advanced_filters_category_manage_terms",
			'edit_terms'		=> "ait_advanced_filters_category_edit_terms",
			'delete_terms'		=> "ait_advanced_filters_category_delete_terms",
			'assign_terms'		=> "ait_advanced_filters_category_assign_terms",
		);

		$args = array(
			'hierarchical'		=> false,
			'labels'			=> $labels,
			'show_ui'			=> true,
			'show_admin_column'	=> true,
			'query_var'			=> true,
			'rewrite'			=> array( 'slug' => 'filters' ),
			'capabilities'		=> $capabilities,
		);

		register_taxonomy( 'ait-items_filters', 'ait-item', $args );

	}

	public static function registerAdminCapabilities(){
		$capabilities = array(
			"ait_advanced_filters_category_manage_terms",
			"ait_advanced_filters_category_edit_terms",
			"ait_advanced_filters_category_delete_terms",
			"ait_advanced_filters_category_assign_terms",
		);

		$role = get_role('administrator');
		foreach($capabilities as $val){
			$role->add_cap($val);
		}
	}
	/* TYPE REGISTRATION */

	/* TAXONOMY CUSTOMIZATION */
	public static function filtersAddFormFields($tag){
		?>
		<div class="form-field form-required">
			<label for="ait-items_filters[type]"><?php _e('Type', 'ait-advanced-filters'); ?></label>
			<select name="ait-items_filters[type]" id="ait-reviews[type]" aria-required="true" style="width: 95%">
				<option value="checkbox"><?php _e('Checkbox', 'ait-advanced-filters') ?></option>
			</select>
		</div>
		<div class="form-field">
			<label for="ait-items_filters[icon]"><?php _e('Icon', 'ait-advanced-filters') ?></label>
			<input type="text" name="ait-items_filters[icon]" id="ait-items_filters[icon]" size="25" style="width:70%;" value="">
			<input type="button" class="choose-category-icon-button button button-secondary" <?php echo aitDataAttr('select-image', array('title' => 'Select Image', 'buttonTitle' => __('Insert Image', 'ait-advanced-filters'))); ?> style="width:25%;" value="<?php _e('Select Image', 'ait-advanced-filters') ?>" id="ait-items_filters[icon]-media-button">
			<p><?php _e('Icon image displayed with filter as feature on Item detail page', 'ait-advanced-filters') ?></p>
		</div>
		<?php
	}

	public static function filtersEditFormFields($tag, $taxonomy){
		$id = $tag->term_id;
		$extraFields = get_option( "ait-items_filters_category_{$id}" );
		?>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="ait-items_filters[type]"><?php _e('Type', 'ait-advanced-filters'); ?></label>
			</th>
			<td>
				<select name="ait-items_filters[type]" id="ait-items_filters[type]" aria-required="true" style="width: 95%">
					<option value="checkbox" <?php echo isset($extraFields["type"]) && $extraFields["type"] == "checkbox" ? 'selected' : '' ?>><?php _e('Checkbox', 'ait-advanced-filters') ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="ait-items_filters[icon]"><?php _e('Icon', 'ait-advanced-filters'); ?></label>
			</th>
			<td>
				<input type="text" name="ait-items_filters[icon]" id="ait-items_filters[icon]" size="25" style="width:70%;" value="<?php echo isset($extraFields["icon"]) ? $extraFields["icon"] : ''; ?>">
				<input type="button" class="choose-category-icon-button button button-secondary" <?php echo aitDataAttr('select-image', array('title' => 'Select Image', 'buttonTitle' => __('Insert Image', 'ait-advanced-filters'))); ?> style="width:25%;" value="<?php _e('Select Image', 'ait-advanced-filters') ?>" id="ait-items_filters[icon]-media-button">
				<p class="description"><?php _e('Icon image displayed with filter as feature on Item detail page', 'ait-advanced-filters') ?></p>
			</td>
		</tr>
		<?php
	}

	public static function filtersSaveFormFields($term_id){
		if ( isset( $_POST['ait-items_filters'] ) ) {
			$extraFields = get_option( "ait-items_filters_category_{$term_id}");
			$keys = array_keys($_POST['ait-items_filters']);
			foreach ($keys as $key){
				$extraFields[$key] = $_POST['ait-items_filters'][$key];
			}
			update_option("ait-items_filters_category_{$term_id}", $extraFields);
		}
	}

	public static function filtersManageColumns($columns){
		unset($columns['taxonomy-ait-items_filters']);
		return $columns;
	}

	public static function filtersTaxonomyColumns($columns){
		unset($columns['posts']);
		return $columns;
	}

	public static function filtersTaxonomyRowActions($actions, $tag){
		unset($actions['view']);
		return $actions;
	}
	/* TAXONOMY CUSTOMIZATION */

	/* ITEM METABOXES */
	public static function addItemMetaboxOptions(){
		if(!class_exists('AitToolkit')) return;
		$manager = AitToolkit::getManager('cpts');
		$allCpts = $manager->getAll();

		$params = array(
			'title' => __('Advanced Filters', 'ait-advanced-filters'),
			'config' => self::$paths['config'].'/ait-item-filters-options.metabox.php',
		);

		foreach($allCpts as $cpt){
			if($cpt->getId() === 'item'){
				$cpt->addMetabox('filters-options', $params);
			}
		}
	}

	public static function removeDefaultTagsMetabox(){
		remove_meta_box( 'tagsdiv-ait-items_filters' , 'ait-item' , 'normal' );
		remove_meta_box( 'pll-tagsdiv-ait-items_filters' , 'ait-item' , 'normal' );
	}
	/* ITEM METABOXES */

	/* FRONTEND TEMPLATES */
	public static function getTemplates($templates, $slug, $name){

		$ok = true;
		foreach(glob(self::$paths['templates'] . '/*.php') as $file){
			$filename = basename($file, '.php');
			if(!self::contains($slug, $filename)){
				$ok = false;
			}else{
				$ok = true;
				break;
			}
		}

		if(!$ok){
			return $templates;
		}

		// create name of file
		// e.g. 'parts/entry-date-format-<NAME>-loop.php'
		// e.g. 'parts/entry-date-format-<NAME>.php'
		if($name){
			//if(!is_singular()) $templates[] = "{$slug}-{$name}-loop.php";
			$templates[] = "{$slug}-{$name}.php";
		}

		// e.g. 'parts/entry-date-format-loop.php'
		// e.g. 'parts/entry-date-format.php'
		//if(!is_singular()) $templates[] = "{$slug}-loop.php";
		$templates[] = "{$slug}.php";

		$locatedInTheme = locate_template($templates, false, false);

		$pluginDir = self::$paths['templates'];

		if(!$locatedInTheme){ // in theme file does not exist, load it from plugin
			$newTemplate = '';
			foreach($templates as $tmpl){
				$tmpl = basename($tmpl);

				if(file_exists("$pluginDir/$tmpl")){
					$newTemplate = "$pluginDir/$tmpl";
				}else{
					continue;
				}
			}
			if(!$newTemplate){
				trigger_error("Template '$tmpl' does not exist in plugin dir nor theme dir");
			}
			return $newTemplate;
		} else {
			return $locatedInTheme; // exist in theme
		}
	}
	/* FRONTEND TEMPLATES */

	/* SCRIPTS, STYLES, ETC */
	public static function enqueueFrontendScripts(){
		wp_enqueue_style( "ait-advanced-filters", plugins_url( '/design/css/advanced-filters.css', __FILE__ ) );
	}

	public static function enqueueAdminScripts(){
		wp_register_style('ait-style-advanced-filters', plugins_url( '/design/css/admin.css', __FILE__ ), false, '1.0.0');
		wp_register_script('ait-script-advanced-filters', plugins_url( '/design/js/admin.js', __FILE__ ), array('jquery'), '1.0.0', false);

		wp_enqueue_style( 'ait-style-advanced-filters' );
		wp_enqueue_script( 'ait-script-advanced-filters' );
	}
	/* SCRIPTS, STYLES, ETC */

	public static function contains($haystack, $needle)
	{
		return strpos($haystack, $needle) !== FALSE;
	}

}
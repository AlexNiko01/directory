<?php //netteCache[01]000584a:2:{s:4:"time";s:21:"0.44880200 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:98:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-features.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-features.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'fph8cwc27z')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($meta->displayFeatures) { ?>

<?php if (!is_array($meta->features)) { $meta->features = array() ;} ?>

<?php if (defined('AIT_ADVANCED_FILTERS_ENABLED')) { $item_meta_filters = $post->meta('filters-options') ;if (is_array($item_meta_filters->filters) && count($item_meta_filters->filters) > 0) { $custom_features = array() ;$iterations = 0; foreach ($item_meta_filters->filters as $filter_id) { $filter_data = get_term($filter_id, 'ait-items_filters', "OBJECT") ;if ($filter_data) { $filter_meta = get_option( "ait-items_filters_category_".$filter_data->term_id ) ;$filter_icon = isset($filter_meta['icon']) ? $filter_meta['icon'] : "" ;array_push($meta->features, array(
						"icon" => $filter_icon,
						"text" => $filter_data->name,
						"desc" => $filter_data->description
					)) ;} $iterations++; } } } ?>

<?php if (!empty($meta->features)) { $numOfColumns = $settings->featuresColumns ;$displayDesc = $settings->featuresDisplayDesc ?>
		<div<?php if ($_l->tmp = array_filter(array('features-container', "column-{$numOfColumns}"))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
			<h2><?php echo NTemplateHelpers::escapeHtml(__('Our Useful Features & Services', 'wplatte'), ENT_NOQUOTES) ?></h2>
			<div class="content">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($meta->features) as $feature) { $hasImage = $feature['icon'] != '' ? true : false ;$hasTitle = $feature['text'] != '' ? true : false ;$hasText = !empty($feature['desc']) ? true : false ?>

<?php $icon = isset($feature['icon']) && $feature['icon'] != "" ? $feature['icon'] : 'fa-info' ?>
					<div<?php if ($_l->tmp = array_filter(array('feature-container', "feature-{$iterator->counter}", $iterator->isFirst($numOfColumns) ? 'feature-first':null, $iterator->isLast($numOfColumns) ? 'feature-last':null, $displayDesc ? 'desc-on' : 'desc-off', $hasTitle ? 'has-title':null, $hasText ? 'has-text':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
						<div class="feature-icon">
							<i class="fa <?php echo NTemplateHelpers::escapeHtml($icon, ENT_COMPAT) ?>"></i>
						</div>
						<div class="feature-data">
							<?php if ($feature['text']) { ?><h4><?php echo $feature['text'] ?></h4><?php } ?>

<?php if ($displayDesc and !empty($feature['desc'])) { ?>
							<div class="feature-desc">
								<p><?php echo $feature['desc'] ?></p>
							</div>
<?php } ?>
						</div>
					</div>
<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
			</div>
		</div>
<?php } } 
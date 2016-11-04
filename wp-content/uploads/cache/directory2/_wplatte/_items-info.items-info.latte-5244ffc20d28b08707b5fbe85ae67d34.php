<?php //netteCache[01]000594a:2:{s:4:"time";s:21:"0.85880100 1478262878";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:107:"/home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/items-info/items-info.latte";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/items-info/items-info.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'wpz1f8baym')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($element->common('header'), $template->getParameters(), $_l->templates['wpz1f8baym'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

<?php $showLine = $el->option->showLine ;$categories = $wp->categories(array('taxonomy' => 'ait-items', 'hide_empty' => 0)) ;$locations = $wp->categories(array('taxonomy' => 'ait-locations', 'hide_empty' => 0)) ;$resources = get_posts(array('post_type' => 'ait-item', 'category' => 0, 'posts_per_page' => -1)) ;if (defined('AIT_REVIEWS_ENABLED')) { $reviews = get_posts(array('post_type' => 'ait-review', 'posts_per_page' => -1)) ;} ?>
	
	<div class="info-container <?php if ($showLine) { ?>sep-enabled<?php } ?>">
		<span class="infobox info-icon"><?php echo NTemplateHelpers::escapeHtml(__('Statistics:', 'wplatte'), ENT_NOQUOTES) ?></span>
		<span class="infobox info-categories">
			<span class="info-count"><?php echo NTemplateHelpers::escapeHtml(count($categories), ENT_NOQUOTES) ?></span>
			<span class="info-text"><?php echo NTemplateHelpers::escapeHtml(__('Categories', 'wplatte'), ENT_NOQUOTES) ?></span>
		</span>
		<span class="infobox info-locations">
			<span class="info-count"><?php echo NTemplateHelpers::escapeHtml(count($locations), ENT_NOQUOTES) ?></span>
			<span class="info-text"><?php echo NTemplateHelpers::escapeHtml(__('Locations', 'wplatte'), ENT_NOQUOTES) ?></span>
		</span>
		<span class="infobox info-resources">
			<span class="info-count"><?php echo NTemplateHelpers::escapeHtml(count($resources), ENT_NOQUOTES) ?></span>
			<span class="info-text"><?php echo NTemplateHelpers::escapeHtml(__('Resources', 'wplatte'), ENT_NOQUOTES) ?></span>
		</span>
<?php if (defined('AIT_REVIEWS_ENABLED')) { ?>
		<span class="infobox info-reviews">
			<span class="info-count"><?php echo NTemplateHelpers::escapeHtml(count($reviews), ENT_NOQUOTES) ?></span>
			<span class="info-text"><?php echo NTemplateHelpers::escapeHtml(__('Reviews', 'wplatte'), ENT_NOQUOTES) ?></span>
		</span>
<?php } ?>
	</div>
	
</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/items-info/javascript", ""), array() + get_defined_vars(), $_l->templates['wpz1f8baym'])->render() ;
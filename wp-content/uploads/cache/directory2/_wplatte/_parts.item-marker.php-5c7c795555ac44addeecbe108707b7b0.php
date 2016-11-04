<?php //netteCache[01]000568a:2:{s:4:"time";s:21:"0.00660800 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/home/dev/directory/public_html/wp-content/themes/directory2/parts/item-marker.php";i:2;i:1475839493;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/parts/item-marker.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'isb2k0urkm')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$imageUrl = $item->hasImage ? $item->imageUrl : $options->theme->item->noFeatured ?>
<div class="item-data">
	<h3><?php echo $item->title ?></h3>
	<span class="item-address"><?php echo $meta->map['address'] ?></span>
<?php if (defined('AIT_REVIEWS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-map-reviews-stars", ""), array('showCount' => true, 'class' => "gallery-hidden") + get_defined_vars(), $_l->templates['isb2k0urkm'])->render() ;} ?>
	<a href="<?php echo $item->permalink ?>">
		<span class="item-button"><?php echo NTemplateHelpers::escapeHtml(__('Show More', 'wplatte'), ENT_NOQUOTES) ?></span>
	</a>
</div>
<div class="item-picture">
	<img src="<?php echo aitResizeImage($imageUrl, array('width' => 145, 'height' => 180, 'crop' => 1)) ?>" alt="image" />
<?php if ($elements->unsortable['header-map']->option('infoboxEnableTelephoneNumbers') && $meta->telephone) { ?>
	<a href="tel:<?php echo $meta->telephone ?>" class="phone"><?php echo $meta->telephone ?></a>
<?php } ?>
</div>



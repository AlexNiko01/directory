<?php //netteCache[01]000562a:2:{s:4:"time";s:21:"0.47912000 1478262460";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:76:"/home/dev/directory/public_html/wp-content/themes/directory2/single-item.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/single-item.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'vw8ii4702c')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbc34fa1c421_content')) { function _lbc34fa1c421_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;foreach($iterator = new WpLatteLoopIterator() as $post): $meta = $post->meta('item-data') ;$settings = $options->theme->item ?>
						<div class="item-content-wrap" itemscope itemtype="http://schema.org/LocalBusiness">
			<meta itemprop="name" content="<?php echo NTemplateHelpers::escapeHtml($post->title, ENT_COMPAT) ?>" />
<?php $wouldGalleryDisplay = false ;if ($post->hasImage) { $wouldGalleryDisplay = true ;} if ($meta->displayGallery && is_array($meta->gallery) && count($meta->gallery) > 0) { $wouldGalleryDisplay = true ;} ?>

<?php if ($wouldGalleryDisplay == false) { if (defined('AIT_REVIEWS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-reviews-stars", ""), array('showCount' => true, 'class' => "gallery-hidden") + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} } ?>

<?php if ($wouldGalleryDisplay == false) { ?>
				<div class="column-grid column-grid-2">
					<div class="column column-span-2 column-first column-last">
						<div class="entry-content-wrap" itemprop="description">
							<div class="entry-content">
<?php if ($post->hasContent) { ?>
									<?php echo $post->content ?>

<?php } else { ?>
									<?php echo $post->excerpt ?>

<?php } ?>
							</div>
						</div>
					</div>
				</div>
<?php } else { ?>
				<div class="column-grid column-grid-3">
					<div class="column column-span-1 column-narrow column-first">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-gallery", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ?>
										</div>

					<div class="column column-span-2 column-narrow column-last">
						<div class="entry-content-wrap" itemprop="description">
							<div class="entry-content">
<?php if ($post->hasContent) { ?>
									<?php echo $post->content ?>

<?php } else { ?>
									<?php echo $post->excerpt ?>

<?php } ?>
							</div>
						</div>
					</div>
				</div>
<?php } ?>
			
			<div class="column-grid column-grid-3">
				<div class="column column-span-1 column-narrow column-first">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-opening-hours", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ?>
									</div>

				<div class="column column-span-2 column-narrow column-last">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-address", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-contact-owner", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;if (defined('AIT_GET_DIRECTIONS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/get-directions-button", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} ?>
									</div>
			</div>

<?php if (defined('AIT_EXTENSION_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/item-extension", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} if (defined('AIT_CLAIM_LISTING_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/claim-listing", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-map", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;if (defined('AIT_GET_DIRECTIONS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/get-directions-container", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-social", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-features", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;if (defined('AIT_REVIEWS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-reviews", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} if ((defined('AIT_SPECIAL_OFFERS_ENABLED'))) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/single-item-special-offers", ""), array() + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} if ((defined('AIT_EVENTS_PRO_ENABLED')) && AitEventsPro::getEventsByItem($post->id)->found_posts) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-events", ""), array('itemId' => $post->id) + get_defined_vars(), $_l->templates['vw8ii4702c'])->render() ;} ?>
							</div>
<?php endforeach; 
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof NPresenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 
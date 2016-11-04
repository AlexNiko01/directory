<?php //netteCache[01]000578a:2:{s:4:"time";s:21:"0.54118300 1478262914";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:92:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/item-container.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/item-container.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'ctx3buhd33')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$categories = get_the_terms($post->id, 'ait-items') ?>

<?php $meta = $post->meta('item-data') ?>

<?php $dbFeatured = get_post_meta($post->id, '_ait-item_item-featured', true) ;$isFeatured = $dbFeatured != "" ? filter_var($dbFeatured, FILTER_VALIDATE_BOOLEAN) : false ?>

<?php $noFeatured = $options->theme->item->noFeatured ?>

<div<?php if ($_l->tmp = array_filter(array('item-container', $isFeatured ? "item-featured":null, defined("AIT_REVIEWS_ENABLED") ? 'reviews-enabled':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
    <div class="content">

        <div class="item-image">
            <a class="main-link" href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>">
                <span><?php echo NTemplateHelpers::escapeHtml(__('View Detail', 'wplatte'), ENT_NOQUOTES) ?></span>
<?php if ($post->image) { ?>
                <img src="<?php echo aitResizeImage($post->imageUrl, array('width' => 200, 'height' => 240, 'crop' => 1)) ?>" alt="Featured" />
<?php } else { ?>
                <img src="<?php echo aitResizeImage($noFeatured, array('width' => 200, 'height' => 240, 'crop' => 1)) ?>" alt="Featured" />
<?php } ?>
            </a>
<?php if (defined('AIT_REVIEWS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/carousel-reviews-stars", ""), array('item' => $post, 'showCount' => false) + get_defined_vars(), $_l->templates['ctx3buhd33'])->render() ;} ?>
        </div>
        <div class="item-data">
            <div class="item-header">
                <div class="item-title-wrap">
                    <div class="item-title">
                        <a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>">
                            <h3><?php echo $post->title ?></h3>
                        </a>
                    </div>
                    <span class="subtitle"><?php echo NTemplateHelpers::escapeHtml(AitLangs::getCurrentLocaleText($meta->subtitle), ENT_NOQUOTES) ?></span>
                </div>

<?php $target = $meta->socialIconsOpenInNewWindow ? 'target="_blank"' : "" ;if ($meta->displaySocialIcons) { ?>

                        <div class="social-icons-container">
                            <div class="content">
<?php if (count($meta->socialIcons) > 0) { ?>
                                    <ul><!--
<?php $iterations = 0; foreach ($meta->socialIcons as $icon) { ?>
                                    --><li>
                                            <a href="<?php echo $icon['link'] ?>
" <?php echo $target ?>>
                                                <i class="fa <?php echo NTemplateHelpers::escapeHtml($icon['icon'], ENT_COMPAT) ?>"></i>
                                            </a>
                                        </li><!--
<?php $iterations++; } ?>
                                    --></ul>
<?php } ?>
                            </div>
                        </div>

<?php } ?>

<?php if (count($categories) > 0) { ?>
                <div class="item-categories">
<?php $iterations = 0; foreach ($categories as $category) { $catLink = get_term_link($category) ?>
                        <a href="<?php echo NTemplateHelpers::escapeHtml($catLink, ENT_COMPAT) ?>
"><span class="item-category"><?php echo $category->name ?></span></a>
<?php $iterations++; } ?>
                </div>
<?php } ?>
            </div>
            <div class="item-body">
                <div class="entry-content">
                    <p class="txtrows-4">
<?php if ($post->hasExcerpt) { ?>
                            <?php echo $template->truncate($template->trim($template->striptags($post->excerpt)), 250) ?>

<?php } else { ?>
                            <?php echo $template->truncate($template->trim($template->striptags($post->content)), 250) ?>

<?php } ?>
                    </p>
                </div>
            </div>
            <div class="item-footer">
<?php if ($meta->map['address']) { ?>
                <div class="item-address">
                    <span class="label"><?php echo NTemplateHelpers::escapeHtml(__('Address:', 'wplatte'), ENT_NOQUOTES) ?></span>
                    <span class="value"><?php echo NTemplateHelpers::escapeHtml($meta->map['address'], ENT_NOQUOTES) ?></span>
                </div>
<?php } ?>

<?php if ($meta->web) { ?>
                <div class="item-web">
                    <span class="label"><?php echo NTemplateHelpers::escapeHtml(__('Web:', 'wplatte'), ENT_NOQUOTES) ?></span>
                    <span class="value"><a href="<?php echo $meta->web ?>" target="_blank" <?php if ($options->theme->item->addressWebNofollow) { ?>
rel="nofollow"<?php } ?>><?php if ($meta->webLinkLabel) { echo NTemplateHelpers::escapeHtml($meta->webLinkLabel, ENT_NOQUOTES) ;} else { echo NTemplateHelpers::escapeHtml($meta->web, ENT_NOQUOTES) ;} ?></a></span>
                </div>
<?php } ?>

<?php if (!is_array($meta->features)) { $meta->features = array() ;} ?>

<?php if (defined('AIT_ADVANCED_FILTERS_ENABLED')) { $item_meta_filters = $post->meta('filters-options') ;if (is_array($item_meta_filters->filters) && count($item_meta_filters->filters) > 0) { $custom_features = array() ;$iterations = 0; foreach ($item_meta_filters->filters as $filter_id) { $filter_data = get_term($filter_id, 'ait-items_filters', "OBJECT") ;if ($filter_data) { $filter_meta = get_option( "ait-items_filters_category_".$filter_data->term_id ) ;$filter_icon = isset($filter_meta['icon']) ? $filter_meta['icon'] : "" ;array_push($meta->features, array(
                                    "icon" => $filter_icon,
                                    "text" => $filter_data->name,
                                    "desc" => $filter_data->description
                                )) ;} $iterations++; } } } ?>


<?php if (is_array($meta->features) && count($meta->features) > 0) { ?>
                <div class="item-features">
                    <div class="label"><?php echo NTemplateHelpers::escapeHtml(__('Features:', 'wplatte'), ENT_NOQUOTES) ?></div>
                    <div class="value">
                        <ul class="item-filters">
<?php $iterations = 0; foreach ($meta->features as $filter) { $imageClass = $filter['icon'] != '' ? 'has-image' : '' ;$textClass = $filter['text'] != '' ? 'has-text' : '' ?>

                            <li class="item-filter <?php echo NTemplateHelpers::escapeHtml($imageClass, ENT_COMPAT) ?>
 <?php echo NTemplateHelpers::escapeHtml($textClass, ENT_COMPAT) ?>">
<?php if ($filter['icon'] != '') { ?>
                                <i class="fa <?php echo NTemplateHelpers::escapeHtml($filter['icon'], ENT_COMPAT) ?>"></i>
<?php } ?>
                                <span class="filter-hover">
                                    <?php echo $filter['text'] ?>

                                </span>

                            </li>
<?php $iterations++; } ?>
                        </ul>
                    </div>
                </div>
<?php } ?>


            </div>
        </div>
    </div>

</div>
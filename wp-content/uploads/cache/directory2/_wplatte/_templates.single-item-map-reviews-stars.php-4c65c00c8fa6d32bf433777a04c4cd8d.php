<?php //netteCache[01]000599a:2:{s:4:"time";s:21:"0.00130400 1478265272";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:112:"/home/niko/directory/public_html/wp-content/plugins/ait-item-reviews/templates/single-item-map-reviews-stars.php";i:2;i:1478264647;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/niko/directory/public_html/wp-content/plugins/ait-item-reviews/templates/single-item-map-reviews-stars.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'z6xjg0qaq6')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$rating_count = AitItemReviews::getRatingCount($item->id) ;$rating_mean = floatval(get_post_meta($item->id, 'rating_mean', true)) ?>

<?php $showCount = isset($showCount) ? $showCount : false ?>
<div class="review-stars-container">
<?php if ($rating_count > 0) { ?>
		<div class="content" itemscope itemtype="http://schema.org/AggregateRating">
						<span style="display: none" itemprop="itemReviewed"><?php echo $item->title ?></span>
			<span style="display: none" itemprop="ratingValue"><?php echo NTemplateHelpers::escapeHtml($rating_mean, ENT_NOQUOTES) ?></span>
			<span style="display: none" itemprop="ratingCount"><?php echo NTemplateHelpers::escapeHtml($rating_count, ENT_NOQUOTES) ?></span>
						<span class="review-stars" data-score="<?php echo NTemplateHelpers::escapeHtml($rating_mean, ENT_COMPAT) ?>"></span>
			<?php if ($showCount) { ?><span class="review-count">(<?php echo NTemplateHelpers::escapeHtml($rating_count, ENT_NOQUOTES) ?>
)</span><?php } ?>

<!--			<a href="<?php echo NTemplateHelpers::escapeHtmlComment($item->permalink) ?>
#review">--><?php //_e('Submit your rating', 'ait-item-reviews') ?><!--</a>-->
		</div>
<?php } else { ?>
		<div class="content">
<!--			<a href="<?php echo NTemplateHelpers::escapeHtmlComment($item->permalink) ?>
#review">--><?php //_e('Submit your rating', 'ait-item-reviews') ?><!--</a>-->
		</div>
<?php } ?>
</div>
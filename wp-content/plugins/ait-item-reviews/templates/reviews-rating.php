{var $rating_count = AitItemReviews::getRatingCount($item->id)}
{var $rating_mean = floatval(get_post_meta($item->id, 'rating_mean', true))}

{var $showCount = isset($showCount) ? $showCount : false}
<div class="review-stars-container">
	{if $rating_count > 0}
		<div class="content" itemscope itemtype="http://schema.org/AggregateRating">
			{* RICH SNIPPETS *}
			<span style="display: none" itemprop="itemReviewed">{!$item->title}</span>
			<span style="display: none" itemprop="ratingValue">{$rating_mean}</span>
			<span style="display: none" itemprop="ratingCount">{$rating_count}</span>
			{* RICH SNIPPETS *}
			<span class="review-stars" data-score="{$rating_mean}"></span>
			{if $showCount}<span class="review-count">({$rating_count})</span>{/if}
<!--			<a href="{$item->permalink}#review">--><?php //_e('Submit your rating', 'ait-item-reviews') ?><!--</a>-->
		</div>
	{else}
		<div class="content">
<!--			<a href="{$item->permalink}#review">--><?php //_e('Submit your rating', 'ait-item-reviews') ?><!--</a>-->
		</div>
	{/if}
</div>

<?php

$posts = get_posts(array(
	'post_type' => 'ait-items',
	'order' => 'DESC',
	'orderby' => 'meta_value',
	'meta_query' => array(
		array('key' => 'rating_mean'))
));

var_dump($posts);
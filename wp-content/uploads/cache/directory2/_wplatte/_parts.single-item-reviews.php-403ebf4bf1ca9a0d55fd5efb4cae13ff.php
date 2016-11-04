<?php //netteCache[01]000583a:2:{s:4:"time";s:21:"0.47446600 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:97:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-reviews.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-reviews.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'qdo2y6fsn5')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$ratingsDisplayedClass = AitItemReviews::hasReviewQuestions($post->id) ? 'ratings-shown' : 'ratings-hidden' ?>

<div class="reviews-container <?php echo NTemplateHelpers::escapeHtml($ratingsDisplayedClass, ENT_COMPAT) ?>" id="review">
	<h2><?php _e('Leave a Review', 'ait') ?></h2>

<?php $current_rating_count = AitItemReviews::getReviewCount($post->id) ;$current_rating_mean = get_post_meta($post->id, 'rating_mean', true) ;if ($current_rating_count > 0) { ?>
	<div class="current-rating-container review-stars-container">
		<h3><?php _e('Your Rating', 'ait') ?></h3>
		<!--<div class="content">
			<span class="current-stars review-stars" data-score="<?php echo NTemplateHelpers::escapeHtmlComment($current_rating_mean) ?>"></span>
		</div>-->
	</div>
<?php } NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-item-reviews-form", ""), array() + get_defined_vars(), $_l->templates['qdo2y6fsn5'])->render() ?>

<?php if ($options->theme->itemReviews->maxShownReviews == 'all') { $reviews_query = AitItemReviews::getCurrentItemReviews($post->id) ;} else { $reviews_query = AitItemReviews::getCurrentItemReviews($post->id, array('posts_per_page' => intval($options->theme->itemReviews->maxShownReviews), 'nopaging' => false)) ;} ?>

<?php if (count($reviews_query->posts) > 0) { ?>
	<div class="content">
<?php foreach ($iterator = new WpLatteLoopIterator($reviews_query) as $review): ?>

<?php $rating_overall = get_post_meta($review->id, 'rating_mean', true) ;$rating_data = (array)json_decode(get_post_meta($review->id, 'ratings', true)) ?>

<?php $ratingsDisplayedClass = AitItemReviews::willRatingsDisplay($rating_data) ? 'ratings-shown' : 'ratings-hidden' ?>

<?php $dateFormat = get_option('date_format') ?>

		<div class="review-container <?php echo NTemplateHelpers::escapeHtml($ratingsDisplayedClass, ENT_COMPAT) ?>">
			<div class="review-info">
				<span class="review-name"><?php echo NTemplateHelpers::escapeHtml($review->title, ENT_NOQUOTES) ?></span>
				<span class="review-time"><span><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($review->rawDate, $dateFormat), ENT_NOQUOTES) ?>
</span>&nbsp;<span><?php echo NTemplateHelpers::escapeHtml($review->time(), ENT_NOQUOTES) ?></span></span>
<?php if (is_array($rating_data) && count($rating_data) > 0) { ?>
				<div class="review-stars">
					<span class="review-rating-overall" data-score="<?php echo NTemplateHelpers::escapeHtml($rating_overall, ENT_COMPAT) ?>"></span>
					<div class="review-ratings">
<?php $iterations = 0; foreach ($rating_data as $index => $rating) { if ($rating->question) { ?>
							<div class="review-rating">
								<span class="review-rating-question">
									<?php echo NTemplateHelpers::escapeHtml($rating->question, ENT_NOQUOTES) ?>

								</span>
								<span class="review-rating-stars" data-score="<?php echo NTemplateHelpers::escapeHtml($rating->value, ENT_COMPAT) ?>"></span>
							</div>
<?php } $iterations++; } ?>
					</div>
				</div>
<?php } ?>
			</div>
			<div class="content">
				<?php echo $review->content ?>

			</div>
						<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Review",
				"itemReviewed": {
					"@type": "Thing",
					"name": "<?php echo $post->title ?>"
				},
				"reviewRating": {
					"@type": "Rating",
					"ratingValue": "<?php echo $rating_overall ?>"
				},
				"author": {
					"@type": "Person",
					"name": "<?php echo $review->title ?>"
				},
				"reviewBody": "<?php echo strip_tags($review->content) ?>"
			}
			</script>
					</div>
<?php endforeach; wp_reset_postdata() ?>

<?php if ($options->theme->itemReviews->maxShownReviews != "all") { if ($reviews_query->found_posts - count($reviews_query->posts) != 0) { ?>
			<div class="reviews-ajax-container" data-all="<?php echo NTemplateHelpers::escapeHtml($reviews_query->found_posts, ENT_COMPAT) ?>
" data-shown="<?php echo NTemplateHelpers::escapeHtml(count($reviews_query->posts), ENT_COMPAT) ?>">
				<span class="reviews-ajax-icon"><i data-icon-show="fa-angle-down" data-icon-hide="fa-angle-up" class="fa fa-angle-down"></i></span>
				<span class="reviews-ajax-info">
					<?php echo $template->printf(__("There are %s next ratings", 'wplatte'), "<span class='ajax-info-count'>" . ($reviews_query->found_posts - count($reviews_query->posts)) . "</span>") ?>

				</span>
				<a href="#" class="reviews-ajax-button" data-text-show="<?php echo NTemplateHelpers::escapeHtml(__("View Next Ratings", 'wplatte'), ENT_COMPAT) ?>
" data-text-hide="<?php echo NTemplateHelpers::escapeHtml(__("Hide Ratings", 'wplatte'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml(__("View Next Ratings", 'wplatte'), ENT_NOQUOTES) ?></a>

				<script type="text/javascript">
				jQuery(document).ready(function(){
					var $container = jQuery('.reviews-ajax-container');
					var params = {
						'action': 'loadReviews',
						'data': {
							'post_id': <?php echo NTemplateHelpers::escapeJs($post->id) ?>,
							'query': {
								'offset': <?php echo NTemplateHelpers::escapeJs(intval($options->theme->itemReviews->maxShownReviews)) ?>,
								'nopaging': false,
								'posts_per_page': <?php echo NTemplateHelpers::escapeJs(intval($reviews_query->found_posts)) ?>,
							},
						}
					};

					jQuery.ajax({
						type: "POST",
						url: ait.ajax.url,
						data: params,
						beforeSend: function(){

						},
						success: function(data){
							jQuery(data.html).insertBefore('.reviews-ajax-container');

							var selectors = [
								".review-container .review-rating-overall",
								".review-container .review-rating-stars"
							];
							jQuery(selectors.join(', ')).raty({
								font: true,
								readOnly:true,
								halfShow:true,
								starHalf:'fa-star-half-o',
								starOff:'fa-star-o',
								starOn:'fa-star',
								score: function() {
									return jQuery(this).attr('data-score');
								},
							});

							//jQuery('.reviews-ajax-container .reviews-ajax-button').addClass('ajax-button-disabled');

							// update maximum height
							var expandedHeight = parseInt(jQuery('.reviews-container').children('.content').attr('data-height-expanded'));
							jQuery('.reviews-container').find('.review-ajax-loaded').each(function(){
								jQuery(this).css({'display' : 'block', 'visibility' : 'hidden'});
								expandedHeight = expandedHeight + jQuery(this).outerHeight(true);
								jQuery(this).css({'display' : '', 'visibility' : ''});
							});
							jQuery('.reviews-container').children('.content').attr('data-height-expanded', expandedHeight);
						},
					});

					var $contentContainer = jQuery('.reviews-container').children('.content');
					$contentContainer.attr('data-height-collapsed', $contentContainer.height());
					$contentContainer.attr('data-height-expanded', $contentContainer.height());
					//$contentContainer.attr('data-height-single', $contentContainer.find('.review-container:last').outerHeight(true));
					$contentContainer.css({'height': $contentContainer.attr('data-height-collapsed')});
				});

				jQuery('.reviews-ajax-container .reviews-ajax-button').on('click', function(e){
					e.preventDefault();
					var $container = jQuery('.reviews-container');
					var $contentContainer = $container.children('.content');
					var $iconContainer = $container.find('.reviews-ajax-icon');

					var timeout = $container.hasClass('reviews-ajax-shown') ? 250 : 750;

					$container.toggleClass('reviews-ajax-shown');
					if($container.hasClass('reviews-ajax-shown')){
						jQuery(this).html(jQuery(this).attr('data-text-hide'));
						$iconContainer.find('i').toggleClass($iconContainer.find('i').attr('data-icon-show'));
						$iconContainer.find('i').toggleClass($iconContainer.find('i').attr('data-icon-hide'));

						//$contentContainer.css({'height': parseInt($contentContainer.attr('data-height-collapsed')) + parseInt( jQuery('.review-ajax-loaded').length * $contentContainer.attr('data-height-single') )  });
						$contentContainer.css({'height': parseInt($contentContainer.attr('data-height-expanded'))});
						
						$contentContainer.find('.reviews-ajax-info').hide();
					} else {
						jQuery(this).html(jQuery(this).attr('data-text-show'));
						$iconContainer.find('i').toggleClass($iconContainer.find('i').attr('data-icon-hide'));
						$iconContainer.find('i').toggleClass($iconContainer.find('i').attr('data-icon-show'));

						$contentContainer.css({'height': $contentContainer.attr('data-height-collapsed')});

						$contentContainer.find('.reviews-ajax-info').show();
					}

					setTimeout(function(){
						$container.find('.review-ajax-loaded').each(function(){
							if($container.hasClass('reviews-ajax-shown')){
								// fade in
								jQuery(this).fadeIn("slow");
							} else {
								// fade out
								jQuery(this).fadeOut("fast");
							}
						});

						//$container.find('.review-ajax-loaded').toggleClass('review-hidden');
					}, timeout);

					//$container.find('.review-ajax-loaded').toggleClass('review-hidden');


					/*$container.find('.review-ajax-loaded').each(function(){

					});*/

					/*if($container.hasClass('reviews-ajax-shown')){
						// showing
						$container.find('.review-ajax-loaded').each(function(){
							jQuery(this)
						});
					} else {
						// collapsing
					}*/

				});
				</script>
			</div>
<?php } ?>

<?php } ?>


		<script type="text/javascript">
			jQuery(document).ready(function() {

				/* Review Tooltip Off-screen Check */

				jQuery('#review .review-container:nth-last-of-type(-n+3) .review-stars').mouseenter(function() {
					reviewOffscreen(jQuery(this));
				});

				function reviewOffscreen(rating) {
					var reviewContainer = rating.find('.review-ratings');
					if (!reviewContainer.hasClass('off-screen')) {
						var	bottomOffset = jQuery(document).height() - rating.offset().top - reviewContainer.outerHeight() - 30;
						if (bottomOffset < 0) reviewContainer.addClass('off-screen');
					}
				}
			});
		</script>

	</div>
<?php } ?>
</div>

<?php //netteCache[01]000600a:2:{s:4:"time";s:21:"0.81933600 1478262878";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:113:"/home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/taxonomy-list/taxonomy-list.latte";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/taxonomy-list/taxonomy-list.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'up9qjslbwf')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($element->common('header'), $template->getParameters(), $_l->templates['up9qjslbwf'])->render() ?>

<?php if ($el->option->layout == 'box') { $enableCarousel  = $el->option->boxEnableCarousel ;} elseif ($el->option->layout == 'icon') { $enableCarousel  = $el->option->iconEnableCarousel ;} else { $enableCarousel  = $el->option->listEnableCarousel ;} ?>

<?php if ($el->option->layout == 'icon' && $enableCarousel) { ?>
<div class="icon-container-content">
<div class="icon-container">
<?php } ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="elm-item-organizer <?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

<?php $taxonomy = $el->option('taxonomy') == 'aititems' ? 'ait-items' : 'ait-locations' ?>

<?php $terms = get_terms($taxonomy, array(
		'orderby' => $el->option('orderby'),
		'order' => $el->option('order'),
		'parent' => 0
	)) ?>

<?php if (is_array($terms) && count($terms) > 0) { $layout = $el->option->layout ;$imageGrey = $el->option->imageGrey ;$imageDisplay = $taxonomy == 'ait-locations' ? $el->option->imageDisplay : 'icon' ;if ($layout == 'box') { $enableCarousel  = $el->option->boxEnableCarousel ;$boxAlign 		  = $el->option->boxAlign ;$numOfRows       = $el->option->boxRows ;$numOfColumns    = $el->option->boxColumns ;$displayDesc	  = $el->option->boxDisplayDesc ;$textRows 		  = $el->option->boxTextRows ;$imageHeight     = $el->option->boxImageHeight ?>
			<?php if ($taxonomy == 'ait-locations') { $imgWidth = 250 ?>
			<?php } else { ?>												<?php $imgWidth = 80 ;} ?>

<?php } elseif ($layout == 'icon') { $enableCarousel  = $el->option->iconEnableCarousel ;$boxAlign 		  = $el->option->iconAlign ;$numOfRows       = 1 ;$numOfColumns    = 6 ;$imageHeight     = $el->option->iconImageHeight ;$imgWidth = 80 ;} else { $enableCarousel  = $el->option->listEnableCarousel ;$numOfRows       = $el->option->listRows ;$numOfColumns    = $el->option->listColumns ;$displayDesc	  = $el->option->listDisplayDesc ;$textRows 		  = $el->option->listTextRows ;$imageHeight     = $el->option->listImageHeight ;$imgWidth = 80 ;} ?>

<?php if ($enableCarousel) { ?>
			<div class="loading"><span class="ait-preloader"><?php echo __('Loading&hellip;', 'wplatte') ?></span></div>
<?php } ?>

<?php if ($layout == 'box') { ?>
						<div data-cols="<?php echo NTemplateHelpers::escapeHtml($numOfColumns, ENT_COMPAT) ?>
" data-first="1" data-last="<?php echo NTemplateHelpers::escapeHtml(ceil(count($terms) / $numOfRows), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('elm-item-organizer-container', "column-{$numOfColumns}", "layout-{$layout}", "img-type-{$imageDisplay}", "img-size-{$imageHeight}", $imageGrey ? 'greyscale':null, $enableCarousel ? 'carousel-container' : 'carousel-disabled',))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($terms) as $term) { $title = $term->name ;$desc = $term->description ;$link = get_term_link( $term ) ?>

<?php $image = "" ;$term_meta = get_option($term->taxonomy . "_category_" . $term->term_id) ;if (is_array($term_meta)) { if ($term->taxonomy == 'ait-items') { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->categoryDefaultIcon ;} else { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->locationDefaultIcon ;} ?>

<?php if ($imageDisplay == 'image') { $image = isset($term_meta['taxonomy_image']) ? $term_meta['taxonomy_image'] : "" ;} } ?>

<?php if ($enableCarousel and $iterator->isFirst($numOfRows)) { ?>
					<div<?php if ($_l->tmp = array_filter(array('item-box', $enableCarousel ? 'carousel-item':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php } ?>
				<div data-id="<?php echo NTemplateHelpers::escapeHtml($iterator->counter, ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('item', "item{$iterator->counter}", $enableCarousel ? 'carousel-item':null, $iterator->isFirst($numOfColumns) ? 'item-first':null, $iterator->isLast($numOfColumns) ? 'item-last':null, $image != "" ? 'image-present':null, $boxAlign ? $boxAlign:null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
					<a href="<?php echo NTemplateHelpers::escapeHtml($link, ENT_COMPAT) ?>">
<?php if ($image) { ?>

<?php if ($imageHeight == "small" || $imageHeight == "medium" || $imageHeight == "large") { $ratio = explode(":", "1:1") ;} else { $ratio = explode(":", $imageHeight) ;} ?>

<?php $imgHeight = ($imgWidth / $ratio[0]) * $ratio[1] ?>
							<div class="item-thumbnail">
								<div class="item-thumbnail-wrap">

									<img src="<?php echo aitResizeImage($image, array('width' => $imgWidth, 'height' => $imgHeight, 'crop' => 1)) ?>
" alt="<?php echo $title ?>" />

								</div>
							</div>
<?php } ?>

						<div class="item-title"><h3><?php echo $title ?></h3></div>

					</a>
<?php if ($displayDesc) { ?>
					<div class="item-text">
						<div class="item-excerpt txtrows-<?php echo NTemplateHelpers::escapeHtml($textRows, ENT_COMPAT) ?>
"><p><?php echo $template->trimWords($template->striptags($desc), 50) ?></p></div>
					</div>
<?php } ?>
				</div>

<?php if ($enableCarousel and $iterator->isLast($numOfRows)) { ?>
					</div>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
			</div>
<?php } elseif ($layout == 'icon') { ?>
						<div data-cols="<?php echo NTemplateHelpers::escapeHtml($numOfColumns, ENT_COMPAT) ?>
" data-first="1" data-last="<?php echo NTemplateHelpers::escapeHtml(ceil(count($terms) / $numOfRows), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('elm-item-organizer-container', "img-type-{$imageDisplay}", "img-size-{$imageHeight}", $imageGrey ? 'greyscale':null, $enableCarousel ? 'carousel-container' : 'carousel-disabled',))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($terms) as $term) { $title = $term->name ;$desc = $term->description ;$link = get_term_link( $term ) ?>

<?php $image = "" ;$term_meta = get_option($term->taxonomy . "_category_" . $term->term_id) ;if (is_array($term_meta)) { if ($term->taxonomy == 'ait-items') { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->categoryDefaultIcon ;} else { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->locationDefaultIcon ;} ?>

<?php if ($imageDisplay == 'image') { $image = isset($term_meta['taxonomy_image']) ? $term_meta['taxonomy_image'] : "" ;} } ?>

<?php if ($enableCarousel and $iterator->isFirst($numOfRows)) { ?>
					<div<?php if ($_l->tmp = array_filter(array('item-box', $enableCarousel ? 'carousel-item':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php } ?>
				<div data-id="<?php echo NTemplateHelpers::escapeHtml($iterator->counter, ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('item', "item{$iterator->counter}", $enableCarousel ? 'carousel-item':null, $iterator->isFirst($numOfColumns) ? 'item-first':null, $iterator->isLast($numOfColumns) ? 'item-last':null, $image != "" ? 'image-present':null, $boxAlign ? $boxAlign:null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
					<a href="<?php echo NTemplateHelpers::escapeHtml($link, ENT_COMPAT) ?>">
<?php if ($image) { ?>

<?php if ($imageHeight == "small" || $imageHeight == "medium" || $imageHeight == "large") { $ratio = explode(":", "1:1") ;} else { $ratio = explode(":", $imageHeight) ;} ?>

<?php $imgHeight = ($imgWidth / $ratio[0]) * $ratio[1] ?>
							<div class="item-thumbnail">
								<div class="item-thumbnail-wrap">
									<img src="<?php echo aitResizeImage($image, array('width' => $imgWidth, 'height' => $imgHeight, 'crop' => 1)) ?>
" alt="<?php echo $title ?>" />
								</div>
							</div>
<?php } ?>

						<div class="item-title"><h3><?php echo $title ?></h3></div>
					</a>
				</div>

<?php if ($enableCarousel and $iterator->isLast($numOfRows)) { ?>
					</div>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
			</div>
<?php } else { ?>
						<div data-cols="<?php echo NTemplateHelpers::escapeHtml($numOfColumns, ENT_COMPAT) ?>
" data-first="1" data-last="<?php echo NTemplateHelpers::escapeHtml(ceil(count($terms) / $numOfRows), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('elm-item-organizer-container', "column-{$numOfColumns}", "layout-{$layout}", "img-type-{$imageDisplay}", "img-size-{$imageHeight}", $imageGrey ? 'greyscale':null, $imageHeight == 'small' ? 'icon-thumb':null, $enableCarousel ? 'carousel-container' : 'carousel-disabled',))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($terms) as $term) { $title = $term->name ;$desc = $term->description ;$link = get_term_link( $term ) ?>

<?php $image = "" ;$term_meta = get_option($term->taxonomy . "_category_" . $term->term_id) ;if (is_array($term_meta)) { if ($term->taxonomy == 'ait-items') { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->categoryDefaultIcon ;} else { $image = isset($term_meta['icon']) && $term_meta['icon'] != "" ? $term_meta['icon'] : $options->theme->items->locationDefaultIcon ;} ?>

<?php if ($imageDisplay == 'image') { $image = isset($term_meta['taxonomy_image']) ? $term_meta['taxonomy_image'] : "" ;} } ?>

<?php if ($enableCarousel and $iterator->isFirst($numOfRows)) { ?>
					<div<?php if ($_l->tmp = array_filter(array('item-box', $enableCarousel ? 'carousel-item':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php } ?>

				<div	data-id="<?php echo NTemplateHelpers::escapeHtml($iterator->counter, ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('item', "item{$iterator->counter}", $enableCarousel ? 'carousel-item':null, $iterator->isFirst($numOfColumns) ? 'item-first':null, $iterator->isLast($numOfColumns) ? 'item-last':null, $image ? 'image-present':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
					<a href="<?php echo NTemplateHelpers::escapeHtml($link, ENT_COMPAT) ?>">
<?php if ($image) { ?>

<?php if ($imageHeight == "small" || $imageHeight == "medium" || $imageHeight == "large") { $ratio = explode(":", "1:1") ;} else { $ratio = explode(":", $imageHeight) ;} ?>

<?php $imgHeight = ($imgWidth / $ratio[0]) * $ratio[1] ?>
							<div class="item-thumbnail">
								<div class="item-thumbnail-wrap">

									<img src="<?php echo aitResizeImage($image, array('width' => $imgWidth, 'height' => $imgHeight, 'crop' => 1)) ?>
" alt="<?php echo $title ?>" />

								</div>
							</div>
<?php } ?>

						<div class="item-title"><h3><?php echo $title ?></h3></div>
					</a>

<?php if ($displayDesc) { ?>
					<div class="item-text">
						<div class="item-excerpt txtrows-<?php echo NTemplateHelpers::escapeHtml($textRows, ENT_COMPAT) ?>
"><p><?php echo $template->trimWords($template->striptags($desc), 50) ?></p></div>
					</div>
<?php } ?>
				</div>

<?php if ($enableCarousel and $iterator->isLast($numOfRows)) { ?>
					</div>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
			</div>
<?php } } else { ?>
		<div class="elm-item-organizer-container">
			<div class="alert alert-info">
				<?php echo NTemplateHelpers::escapeHtml(_x('Taxonomy List', 'name of element', 'wplatte'), ENT_NOQUOTES) ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo NTemplateHelpers::escapeHtml(__('Info: There are no taxonomies created, add some please.', 'wplatte'), ENT_NOQUOTES) ?>

			</div>
		</div>
<?php } ?>

</div>

<?php if ($el->option->layout == 'icon') { ?>
</div>	<!-- icon-container -->
<?php } ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/taxonomy-list/javascript", ""), array('enableCarousel' => $enableCarousel) + get_defined_vars(), $_l->templates['up9qjslbwf'])->render() ?>

<?php if ($el->option->layout == 'icon' && $enableCarousel) { ?>
<div class="carousel-icon-arrows">
	<div class="carousel-arrow-left icon-arrow icon-arrow-left" style="cursor: pointer;">&lt;</div>
	<div class="carousel-arrow-right icon-arrow icon-arrow-right" style="cursor: pointer;">&gt;</div>
</div>

</div> <!-- icon-container-content -->
<?php } ?>


<?php if ($el->option->layout != 'icon' && $enableCarousel) { ?>
<div class="carousel-standard-arrows">
	<div class="carousel-arrow-left standard-arrow standard-arrow-left" style="cursor: pointer;">&lt;</div>
	<div class="carousel-arrow-right standard-arrow standard-arrow-right" style="cursor: pointer;">&gt;</div>
</div>
<div class="carousel-bottom-arrows">
	<div class="carousel-nav-text"><?php echo NTemplateHelpers::escapeHtml(__('Navigation', 'wplatte'), ENT_NOQUOTES) ?></div>
	<div class="carousel-arrow-left bottom-arrow bottom-arrow-left" style="cursor: pointer;">&lt;</div>
	<div class="carousel-arrow-right bottom-arrow bottom-arrow-right" style="cursor: pointer;">&gt;</div>
</div>
<?php } ?>



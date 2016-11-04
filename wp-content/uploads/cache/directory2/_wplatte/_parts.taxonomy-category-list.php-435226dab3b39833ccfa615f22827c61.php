<?php //netteCache[01]000587a:2:{s:4:"time";s:21:"0.41741100 1478262914";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/taxonomy-category-list.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/taxonomy-category-list.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'j7otzjuzih')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$currentCategory = get_term_by( 'slug', get_query_var($taxonomy), $taxonomy) ;$parentCategory = $currentCategory != false ? $currentCategory->term_id : 0 ;$categories = $wp->categories(array('taxonomy' => $taxonomy, 'hide_empty' => 0, 'parent' => $parentCategory)) ?>

<?php if (isset($categories) && count($categories) > 0) { $columns = $options->theme->items->categoryColumns ?>
	<div class="categories-container">
		<div class="content">
<?php $missingCount = ( ceil( count($categories) / $columns ) * $columns ) - count($categories) ?>
						<ul<?php if ($_l->tmp = array_filter(array("column-{$columns}",))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>><!--
<?php $iterations = 0; foreach ($categories as $category) { $title = $category->title ;$desc = $category->description ;$link = get_term_link( $category->id, $category->taxonomy ) ;$icons = get_option($category->taxonomy . "_category_" . $category->id) ;$icon = "" ?>

<?php if (isset($icons['icon']) && $icons['icon'] != "") { $icon = $icons['icon'] ;} else { if ($category->parentId != 0) { $parent = get_term($category->parentId, $taxonomy) ;$icons = get_option($parent->taxonomy . "_category_" . $parent->term_id) ;if (isset($icons['icon']) && $icons['icon'] != "") { $icon = $icons['icon'] ;} else { if ($taxonomy == "ait-items") { $icon = $options->theme->items->categoryDefaultIcon ;} else { $icon = $options->theme->items->locationDefaultIcon ;} } } else { if ($taxonomy == "ait-items") { $icon = $options->theme->items->categoryDefaultIcon ;} else { $icon = $options->theme->items->locationDefaultIcon ;} } } ?>

				--><li<?php if ($_l->tmp = array_filter(array($title ? 'has-title':null, $icon ? 'has-icon':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
					<a href="<?php echo NTemplateHelpers::escapeHtml($link, ENT_COMPAT) ?>">
						<div class="cat-hdr">
							<span class="cat-ico"><img src="<?php echo NTemplateHelpers::escapeHtml($icon, ENT_COMPAT) ?>" alt="icon" /></span>
							<span class="cat-ttl"><?php echo $title ?></span>
						</div>
<?php if ($desc) { ?>
						<div class="cat-desc txtrows-2">
							<?php echo $template->trimWords($desc, 11) ?>

						</div>
<?php } ?>
					</a>
				</li><!--
<?php $iterations++; } if ($missingCount != 0) { ?>
				--><li class="empty-box-<?php echo NTemplateHelpers::escapeHtml($missingCount, ENT_COMPAT) ?>"></li><!--
<?php } ?>
			--></ul>
		</div>
	</div>
<?php } 
<?php //netteCache[01]000589a:2:{s:4:"time";s:21:"0.36922800 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:102:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-social-icons.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-social-icons.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'gz4vpok193')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if (!isset($meta)) { $meta = $post->meta('item-data') ;} ?>

<?php $target = $meta->socialIconsOpenInNewWindow ? 'target="_blank"' : "" ?>

<?php if ($meta->displaySocialIcons) { ?>
<div class="social-icons-container">
	<div class="content">
<?php if (is_array($meta->socialIcons) && count($meta->socialIcons) > 0) { ?>
			<ul><!--
<?php $iterations = 0; foreach ($meta->socialIcons as $icon) { ?>
			--><li>
					<a href="<?php echo $icon['link'] ?>" <?php echo $target ?>>
						<i class="fa <?php echo NTemplateHelpers::escapeHtml($icon['icon'], ENT_COMPAT) ?>"></i>
					</a>
				</li><!--
<?php $iterations++; } ?>
			--></ul>
<?php } ?>
	</div>
</div>
<?php } 
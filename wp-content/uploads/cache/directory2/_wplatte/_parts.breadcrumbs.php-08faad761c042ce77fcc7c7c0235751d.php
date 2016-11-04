<?php //netteCache[01]000568a:2:{s:4:"time";s:21:"0.24434700 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:82:"/home/dev/directory/public_html/wp-content/themes/directory2/parts/breadcrumbs.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/parts/breadcrumbs.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'z0nkkglrt5')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($options->layout->general->showBreadcrumbs) { ?>
<div class="breadcrumb">
	<!-- <div class="grid-main"> -->
		<?php echo WpLatteMacros::breadcrumbs(array($options->theme->breadcrumbs)) ?>

	<!-- </div> -->
</div>
<?php } 
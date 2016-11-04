<?php //netteCache[01]000581a:2:{s:4:"time";s:21:"0.40300400 1478262466";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:95:"/home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/rule/rule.latte";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/ait-theme/elements/rule/rule.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'i0y3cd857r')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>
 rule-<?php echo NTemplateHelpers::escapeHtml($el->option->type, ENT_COMPAT) ?> rule-<?php echo NTemplateHelpers::escapeHtml($el->option->size, ENT_COMPAT) ;if ($el->option('showTop')) { ?>
 rule-btn-top-wrapper<?php } ?>">
	<div class="grid-main">
		<div class="rule-content">
			<div class="rule-wrap">
				<div class="rule-separator"></div>
				<?php if ($el->option('showTop')) { ?><span class="rule-btn-top"><?php echo NTemplateHelpers::escapeHtml(__('Go on Top', 'wplatte'), ENT_NOQUOTES) ?>
</span><?php } ?>

			</div>
		</div>
	</div>
</div>

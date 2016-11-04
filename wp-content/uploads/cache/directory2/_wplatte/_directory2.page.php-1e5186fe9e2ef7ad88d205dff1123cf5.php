<?php //netteCache[01]000555a:2:{s:4:"time";s:21:"0.42865500 1478262878";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:69:"/home/dev/directory/public_html/wp-content/themes/directory2/page.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/page.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'n9be686eqq')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb114191d33b_content')) { function _lb114191d33b_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;foreach($iterator = new WpLatteLoopIterator() as $post): ?>

		<article <?php echo $post->htmlId ?> class="content-block">
		
<?php if ($post->hasImage) { ?>
			<div class="entry-thumbnail">			
							<a href="<?php echo NTemplateHelpers::escapeHtml($post->imageUrl, ENT_COMPAT) ?>" class="thumb-link">
								<span class="entry-thumbnail-icon">
									<img src="<?php echo aitResizeImage($post->imageUrl, array('width' => 1000, 'height' => 500, 'crop' => 1)) ?>" />
								</span>
							</a>	
					</div>
<?php } ?>

			<div class="entry-content">
				<?php echo $post->content ?>

				<?php echo $post->linkPages ?>

			</div><!-- .entry-content -->

		</article><!-- #post -->
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
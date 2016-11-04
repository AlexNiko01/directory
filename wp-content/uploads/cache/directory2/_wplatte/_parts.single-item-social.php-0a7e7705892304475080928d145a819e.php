<?php //netteCache[01]000582a:2:{s:4:"time";s:21:"0.43312500 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:96:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-social.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-social.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'xdhv4xa57t')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$href = get_permalink($post->id) ;$langLong = AitLangs::getCurrentLocale() ;$langShort = AitLangs::getCurrentLanguageCode() ?>

<div class="social-container">
	<div class="content">
	
		<div class="soc fb">
		
				<div id="fb-root"></div>
		<script>(function(d, s, id){ var js, fjs = d.getElementsByTagName(s)[0]; if(d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/<?php echo $langLong ?>/sdk.js#xfbml=1&version=v2.0"; fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-like" data-href="<?php echo $href ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				
		</div>		
		
		<div class="soc twitter">
		
				<script>!function(d, s, id){ var js, fjs = d.getElementsByTagName(s)[0]; if(!d.getElementById(id)){ js = d.createElement(s); js.id = id; js.src = "https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);}}(document, "script", "twitter-wjs");</script>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $href ?>
" data-lang="<?php echo $langShort ?>">Tweet</a>
					
		</div>	
		
		<div class="soc gplus">
			
				<script type="text/javascript" src="https://apis.google.com/js/platform.js">{ lang: '<?php echo str_replace("_","-",$langLong) ?>' }</script>
		<div class="g-plusone" data-size="medium"></div>
					
		</div>	
			
	</div>
</div>
<?php //netteCache[01]000590a:2:{s:4:"time";s:21:"0.38442000 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:103:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-contact-owner.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-contact-owner.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '3ugiy3igdy')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$disabled = 'yes' ?>

<?php if ($meta->contactOwnerBtn && $meta->email) { $disabled = '' ;} ?>

<div<?php if ($_l->tmp = array_filter(array('contact-owner-container', $disabled ? 'contact-owner-disabled':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>

<?php if (!$disabled) { ?>
	<a href="#contact-owner-popup-form" id="contact-owner-popup-button" class="contact-owner-popup-button"><?php echo NTemplateHelpers::escapeHtml($template->trimWords($settings->contactOwnerButtonTitle, 10), ENT_NOQUOTES) ?></a>
	<div class="contact-owner-popup-form-container" style="display: none">

		<form id="contact-owner-popup-form" class="contact-owner-popup-form" onSubmit="javascript:contactOwnerSubmit(event);">
			<h3><?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerButtonTitle, ENT_NOQUOTES) ?></h3>
			<input type="hidden" name="response-email-address" value="<?php echo NTemplateHelpers::escapeHtml($meta->email, ENT_COMPAT) ?>" />
			<input type="hidden" name="response-email-content" value="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMailForm, ENT_COMPAT) ?>" />
<?php if ($settings->contactOwnerMailFromName) { ?>
			<input type="hidden" name="response-email-sender-name" value="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMailFromName, ENT_COMPAT) ?>" />
<?php } ?>

<?php if ($settings->contactOwnerMailFromEmail) { ?>
			<input type="hidden" name="response-email-sender-address" value="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMailFromEmail, ENT_COMPAT) ?>" />
<?php } else { ?>
			<input type="hidden" name="response-email-sender-address" value="<?php echo NTemplateHelpers::escapeHtml(get_option('admin_email'), ENT_COMPAT) ?>" />
<?php } ?>

			<div class="input-container">
				<input type="text" class="input name" name="user-name" value="" placeholder="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerInputNameLabel, ENT_COMPAT) ?>" id="user-name" />
			</div>

			<div class="input-container">
				<input type="text" class="input email" name="user-email" value="" placeholder="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerInputEmailLabel, ENT_COMPAT) ?>" id="user-email" />
			</div>

			<div class="input-container">
				<input type="text" class="input subject" name="response-email-subject" value="" placeholder="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerInputSubjectLabel, ENT_COMPAT) ?>" id="user-subject" />
			</div>

			<div class="input-container">
				<textarea class="user-message" name="user-message" cols="30" rows="4" placeholder="<?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerInputMessageLabel, ENT_COMPAT) ?>" id="user-message"></textarea>
			</div>

			<div class="input-container btn">
				<button class="contact-owner-send" type="submit"><?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerSendButtonLabel, ENT_NOQUOTES) ?></button>
			</div>

			<div class="messages">
				<div class="message message-success" style="display: none"><?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMessageSuccess, ENT_NOQUOTES) ?></div>
				<div class="message message-error-user" style="display: none"><?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMessageErrorUser, ENT_NOQUOTES) ?></div>
				<div class="message message-error-server" style="display: none"><?php echo NTemplateHelpers::escapeHtml($settings->contactOwnerMessageErrorServer, ENT_NOQUOTES) ?></div>
			</div>
		</form>

	</div>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#contact-owner-popup-button").colorbox({ inline:true, href:"#contact-owner-popup-form" });
	});
	function contactOwnerSubmit(e){
		e.preventDefault();

		var $form = jQuery("#"+e.target.id);
		var $inputs = $form.find('input, textarea');
		var $messages = $form.find('.messages');
		var mailCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var mailParsed = $form.find('.email').val();
		// validate form data
			var passedInputs = 0;
			// check for empty inputs -- all inputs must be filled
			$inputs.each(function(){
				var inputValue = jQuery(this).val();
				if(inputValue !== ""){
					passedInputs = passedInputs + 1;
				}
			});

			// check for email field -- must be a valid email form
			if(passedInputs == $inputs.length && mailCheck.test(mailParsed)){
				// ajax post -- if data are filled
				var data = {};
				$inputs.each(function(){
					data[jQuery(this).attr('name')] = jQuery(this).val();
				});
				ait.ajax.post('contact-owner:send', data).done(function(data){
					if(data.success == true){
						$messages.find('.message-success').fadeIn('fast').delay(3000).fadeOut("fast", function(){
							jQuery.colorbox.close();
							$form.find('input[type=text], textarea').each(function(){
								jQuery(this).attr('value', "");
							});
						});
					} else {
						$messages.find('.message-error-server').fadeIn('fast').delay(3000).fadeOut("fast");
					}
				}).fail(function(){
					$messages.find('.message-error-server').fadeIn('fast').delay(3000).fadeOut("fast");
				});
				// display result based on response data
			} else {
				// display bad message result
				$messages.find('.message-error-user').fadeIn('fast').delay(3000).fadeOut("fast");
			}


	}
	</script>
<?php } else { ?>
	<a href="#contact-owner-popup-form" id="contact-owner-popup-button" class="contact-owner-popup-button"><?php echo NTemplateHelpers::escapeHtml($template->trimWords($settings->contactOwnerButtonDisabledTitle, 10), ENT_NOQUOTES) ?></a>
<?php } ?>
</div>

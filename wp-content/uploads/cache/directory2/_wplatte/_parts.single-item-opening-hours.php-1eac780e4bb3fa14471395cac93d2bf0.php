<?php //netteCache[01]000590a:2:{s:4:"time";s:21:"0.33234600 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:103:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-opening-hours.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-opening-hours.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '8doun1tufp')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($meta->displayOpeningHours) { ?>
<div class="elm-opening-hours-main">
	<h2><?php echo NTemplateHelpers::escapeHtml(__('Opening Hours', 'wplatte'), ENT_NOQUOTES) ?></h2>
	<div class="day-container">
		<div class="day-wrapper">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Monday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $monday = AitLangs::getCurrentLocaleText($meta->openingHoursMonday) ?>
			<div class="day-data">
				<p>
					<?php if ($monday) { echo NTemplateHelpers::escapeHtml($monday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Mo <?php echo NTemplateHelpers::escapeHtml($monday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Tuesday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $tuesday = AitLangs::getCurrentLocaleText($meta->openingHoursTuesday) ?>
			<div class="day-data">
				<p>
					<?php if ($tuesday) { echo NTemplateHelpers::escapeHtml($tuesday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Tu <?php echo NTemplateHelpers::escapeHtml($tuesday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Wednesday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $wednesday = AitLangs::getCurrentLocaleText($meta->openingHoursWednesday) ?>
			<div class="day-data">
				<p>
					<?php if ($wednesday) { echo NTemplateHelpers::escapeHtml($wednesday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="We <?php echo NTemplateHelpers::escapeHtml($wednesday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Thursday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $thursday = AitLangs::getCurrentLocaleText($meta->openingHoursThursday) ?>
			<div class="day-data">
				<p>
					<?php if ($thursday) { echo NTemplateHelpers::escapeHtml($thursday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Th <?php echo NTemplateHelpers::escapeHtml($thursday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Friday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $friday = AitLangs::getCurrentLocaleText($meta->openingHoursFriday) ?>
			<div class="day-data">
				<p>
					<?php if ($friday) { echo NTemplateHelpers::escapeHtml($friday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Fr <?php echo NTemplateHelpers::escapeHtml($friday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper day-sat">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Saturday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $saturday = AitLangs::getCurrentLocaleText($meta->openingHoursSaturday) ?>
			<div class="day-data">
				<p>
					<?php if ($saturday) { echo NTemplateHelpers::escapeHtml($saturday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Sa <?php echo NTemplateHelpers::escapeHtml($saturday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
		<div class="day-wrapper day-sun">
			<div class="day-title"><h5><?php echo NTemplateHelpers::escapeHtml(__('Sunday', 'wplatte'), ENT_NOQUOTES) ?></h5></div>
<?php $sunday = AitLangs::getCurrentLocaleText($meta->openingHoursSunday) ?>
			<div class="day-data">
				<p>
					<?php if ($sunday) { echo NTemplateHelpers::escapeHtml($sunday, ENT_NOQUOTES) ?>

					<meta itemprop="openingHours" content="Su <?php echo NTemplateHelpers::escapeHtml($sunday, ENT_COMPAT) ?>" />
					<?php } else { ?>-<?php } ?>

				</p>
			</div>
		</div>
	</div>
<?php $note = AitLangs::getCurrentLocaleText($meta->openingHoursNote) ;if ($note != "") { ?>
	<div class="note-wrapper">
		<p><?php echo NTemplateHelpers::escapeHtml($note, ENT_NOQUOTES) ?></p>
	</div>
<?php } ?>
</div>
<?php } 
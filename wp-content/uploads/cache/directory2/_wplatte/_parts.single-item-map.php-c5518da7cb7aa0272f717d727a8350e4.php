<?php //netteCache[01]000579a:2:{s:4:"time";s:21:"0.42766000 1478262464";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:93:"/home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-map.php";i:2;i:1475495108;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/dev/directory/public_html/wp-content/themes/directory2/portal/parts/single-item-map.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'lj53m88i8x')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($meta->map['latitude'] && $meta->map['longitude']) { if (($meta->map['latitude'] === "1" && $meta->map['longitude'] === "1") != true) { ?>
<div class="map-container">
	<div class="content" style="height: <?php echo NTemplateHelpers::escapeHtml(NTemplateHelpers::escapeCss($settings->mapHeight), ENT_COMPAT) ?>px">

	</div>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		var $mapContainer = jQuery('.single-ait-item .map-container');
		var $mapContent = $mapContainer.find('.content');

		$mapContent.width($mapContainer.width());

		var styles = [
			{ featureType: "landscape", stylers: [
					{ visibility: "<?php if ($settings->mapDisplayLandscapeShow == false) { ?>off<?php } else { ?>
on<?php } ?>"},
				]
			},
			{ featureType: "administrative", stylers: [
					{ visibility: "<?php if ($settings->mapDisplayAdministrativeShow == false) { ?>
off<?php } else { ?>on<?php } ?>"},
				]
			},
			{ featureType: "road", stylers: [
					{ visibility: "<?php if ($settings->mapDisplayRoadsShow == false) { ?>off<?php } else { ?>
on<?php } ?>"},
				]
			},
			{ featureType: "water", stylers: [
					{ visibility: "<?php if ($settings->mapDisplayWaterShow == false) { ?>off<?php } else { ?>
on<?php } ?>"},
				]
			},
			{ featureType: "poi", stylers: [
					{ visibility: "<?php if ($settings->mapDisplayPoiShow == false) { ?>off<?php } else { ?>
on<?php } ?>"},
				]
			},
		];

		var mapdata = {
			latitude: <?php echo NTemplateHelpers::escapeJs($meta->map['latitude']) ?>,
			longitude: <?php echo NTemplateHelpers::escapeJs($meta->map['longitude']) ?>

		}

		$mapContent.gmap3({
			map: {
				options: {
					center: [mapdata.latitude,mapdata.longitude],
					zoom: <?php echo $settings->mapZoom ?>,
					scrollwheel: false,
					styles: styles,
				}
			},
			marker: {
				values:[
					{ latLng:[mapdata.latitude,mapdata.longitude] }
		        ],
			},
		});
	});

	jQuery(window).resize(function(){
		var $mapContainer = jQuery('.single-ait-item .map-container');
		var $mapContent = $mapContainer.find('.content');

		$mapContent.width($mapContainer.width());
	});
	</script>
</div>

<?php } } 
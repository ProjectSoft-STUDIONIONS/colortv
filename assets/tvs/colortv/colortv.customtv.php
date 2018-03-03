<?php
if (IN_MANAGER_MODE != 'true') {
	die('<h1>Error:</h1><p>Please use the MODx content manager instead of accessing this file directly.</p>');
}
$site_url = MODX_SITE_URL;
$dirTv = str_replace("\\", "/", dirname(__FILE__)."/");
$dirTv = "/" . str_replace(MODX_BASE_PATH, "", $dirTv);
$includeColor = <<<EOD
<script type="text/javascript" src="{$dirTv}js/colpick.js"></script>
<link media="all" rel="stylesheet" href="{$dirTv}css/colpick.css" />
<script type="text/javascript">
	\$js = jQuery.noConflict();
	\$js(document).ready(function(){
		\$js("[data-color]").colpick({
			//layout: 'rgbhex',
			onShow: function(a){
				var parent = \$js(this).parent(),
					top = parent.height(),
					left = 0;
				\$js(a).css({
					'left': left,
					'top' : top,
					'z-index': 200
				});
			},
			onBeforeShow: function(a){
				var input = \$js(a).data('colpick').el,
					color = \$js("#" + \$js(input).data('color')).val();
				\$js(this).colpickSetColor(color);
			},
			onChange: function(a, b, c, d){
				var color="#"+b,
					data = "#" + \$js(d).data('color'),
					parent = \$js(d).parent();
				\$js(data).val(color).trigger('change');
				\$js(d).css({
					'background-color' : color
				});
				parent.attr({
					'colvalue': color
				});
			},
			onSubmit: function(a, b, c, d){
				var color="#"+b,
					data = "#" + \$js(d).data('color'),
					parent = \$js(d).parent();
				\$js(data).val(color);
				parent.attr({
					'colvalue': color
				});
				\$js(d).css({
					'background-color' : color
				}).colpickHide();
			}
		});
	});
</script>
<style>
.colorpicker-block:after {
	content: attr(colvalue);
	display: block;
	padding-top:3px;
	font-size: 16px;
	padding-bottom: 3px;
}
</style>
EOD;
$default = empty($row['default_text']) ? "#ffffff" : $row['default_text'];
$value = empty($row['value']) ? $default : $row['value'];
$id = $row['id'];
$outputColor = <<<EOD
<div class="colorpicker-block" style="position: relative;" colvalue="{$value}">
	<input type="color" style="display: none !important;" id="tv{$id}" name="tv{$id}" value="{$value}" onchange="documentDirty=true;"/>
	<input type="text" style="background-color: {$value};width: 30px;cursor: pointer;" data-color="tv{$id}" readonly="readonly">
</div>
EOD;
echo $outputColor;

if(!defined('COLORTV')) {
	echo $includeColor;
	define('COLORTV', 1);
}
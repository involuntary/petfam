<?php
/*
Plugin Name: Range Slider 1 - 100
Plugin URI: 
Description: 
Version: 1
Updated: 15th September 2014
Author: sMarty  |  
Author URI: 
License:
*/
function range_slider(){
$STRING = '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">';
$STRING .= '<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>';
$STRING .= '<script>
jQuery( document ).ready(function() {
jQuery(function() {
		jQuery( "#slider-range" ).slider({
			range: "max",
			min: 0,
			max: 100,
			value: 10,
			slide: function( event, ui ) {
				jQuery( "#amount" ).val( ui.value );
			}
		});
		jQuery( "#amount" ).val( jQuery( "#slider-range" ).slider( "value" ) );
	});
});	
</script>';
$STRING .= '<input type="text" size="1" id="amount" name="radius" style="border: none;width: 2em;">miles<div id="slider-range"></div>';
return $STRING;
}add_shortcode('RADIUS', 'range_slider');
?>
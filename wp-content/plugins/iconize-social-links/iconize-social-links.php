<?php
/*
Plugin Name: Iconize Social Links for responsive PPT
Plugin URI: http://premiumwebservices.co.uk/shop/
Description: This plugin will add Icons like Facebook, Twitter, Google+, LinkedIn and Pinterest to Social Links entered by users (use customfield keys 'facebook', 'twitter', 'google', 'linkedin' and 'pinterest').
Version: 1.0.0
Author: Richard Bonk
Author URI: http://premiumwebservices.co.uk
*/
function iconize_scripts(){
	if(is_single()) {
		wp_register_style('iconize', plugins_url('css/iconize-style.css', __FILE__));
		wp_enqueue_style('iconize');
	}
}
add_action('wp_enqueue_scripts', 'iconize_scripts');
?>
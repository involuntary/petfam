<?php

/* =============================================================================
   DEBUG OPTIONS
   ========================================================================== */

     //ini_set( 'display_errors', 1 );
     //error_reporting( E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_STRICT );

    //define('WLT_CUSTOMLOGINFORM', false);
    //define('WLT_DEBUG_EMAIL', true);
    //define('WLT_DEBUG_MOBILE', true);
    //define('WLT_DEMOMODE',true);

/* =============================================================================
   LOAD IN FRAMEWORK
   ========================================================================== */

    // LOAD IN CLASS FILES
    if(defined('TEMPLATEPATH') && !defined('THEME_VERSION') ){ include("framework/_config.php"); }

/* =============================================================================
   ADD YOUR CUSTOM CODE BELOW THIS LINE
   ========================================================================== */

include( get_template_directory() . '/custom_shortcodes.php' );

function cpm_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    // wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'cpm_theme_name_scripts' );

 ?>

<?php
ini_set('log_errors', '1');
ini_set('error_log', '/home/wordpressbr/wp-brasil.org/error.log');

add_action( 'wp_enqueue_scripts', 'participe_styles' );
require_once( get_template_directory() . '/inc/ajax.php' );


function participe_styles() {

	wp_register_style( 'p2', get_template_directory_uri().'/style.css' );
	wp_register_style( 'participe', get_stylesheet_uri(), array('p2') );

	wp_enqueue_style( 'p2' );
	wp_enqueue_style( 'participe' );

}

?>
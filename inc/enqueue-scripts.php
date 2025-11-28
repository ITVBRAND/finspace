<?php
/**
 * Enqueue theme scripts
 *
 * @package vbrand_custom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts.
 */
function vbrand_custom_enqueue_scripts() {
	$template_dir_uri = get_template_directory_uri();
	// Header scripts
	wp_enqueue_script( 'vbrand-header', $template_dir_uri . '/assets/scripts/header.js', array(), _S_VERSION, true );
	// Global Form
	wp_enqueue_script( 'global-form', $template_dir_uri . '/assets/scripts/globalModalForm.js', array(), _S_VERSION, true );
	
	// Home page scripts
	if ( is_front_page() || is_home() ) {
		wp_enqueue_script( 'vbrand-home-number', $template_dir_uri . '/assets/scripts/homeNumber.js', array(), _S_VERSION, true );
		wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true );
		wp_enqueue_script( 'vbrand-main-services', $template_dir_uri . '/assets/scripts/mainServices.js', array( 'swiper' ), _S_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'vbrand_custom_enqueue_scripts' );


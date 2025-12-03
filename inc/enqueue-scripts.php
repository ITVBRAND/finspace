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
		wp_enqueue_script( 'vbrand-main-review', $template_dir_uri . '/assets/scripts/mainReview.js', array( 'swiper' ), _S_VERSION, true );
		wp_enqueue_script( 'vbrand-main-blog', $template_dir_uri . '/assets/scripts/mainBlog.js', array( 'swiper' ), _S_VERSION, true );
	}

	// Services archive and single
	if ( is_post_type_archive( 'services' ) || is_singular( 'services' ) || is_tax( 'service_category' ) || is_tax( 'service_tag' ) ) {
		wp_enqueue_script( 'services-accordion', $template_dir_uri . '/assets/scripts/accordion.js', array(), _S_VERSION, true );
		// Service form script for single service pages
		if ( is_singular( 'services' ) ) {
			wp_enqueue_script( 'services-form', $template_dir_uri . '/assets/scripts/servicesForm.js', array(), _S_VERSION, true );
		}
	}

	// About page
	if ( is_page_template( 'templates/page-about.php' ) ) {
		wp_enqueue_script( 'page-about', $template_dir_uri . '/assets/scripts/pageAbout.js', array(), _S_VERSION, true );
		wp_enqueue_script( 'services-accordion', $template_dir_uri . '/assets/scripts/accordion.js', array(), _S_VERSION, true );
	}

}
add_action( 'wp_enqueue_scripts', 'vbrand_custom_enqueue_scripts' );


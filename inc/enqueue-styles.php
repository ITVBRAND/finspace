<?php
/**
 * Enqueue theme styles
 *
 * @package vbrand_custom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts and styles.
 */
function vbrand_custom_scripts() {
	$template_dir_uri = get_template_directory_uri();
	// Normalize CSS
	wp_enqueue_style( 'vbrand-normalize', $template_dir_uri . '/assets/styles/normalize.css', array(), _S_VERSION );
	// Fonts
	wp_enqueue_style( 'vbrand-fonts', $template_dir_uri . '/assets/styles/fonts.css', array( 'vbrand-normalize' ), _S_VERSION );
	// Global styles
	wp_enqueue_style( 'vbrand-global', $template_dir_uri . '/assets/styles/global.css', array( 'vbrand-fonts' ), _S_VERSION );
	// Header styles
	wp_enqueue_style( 'vbrand-header', $template_dir_uri . '/assets/styles/header.css', array( 'vbrand-global' ), _S_VERSION );
	// Footer styles
	wp_enqueue_style( 'vbrand-footer', $template_dir_uri . '/assets/styles/footer.css', array( 'vbrand-global' ), _S_VERSION );
	// Form styles
	wp_enqueue_style( 'global-form', $template_dir_uri . '/assets/styles/modal-contact.css', array( 'vbrand-global' ), _S_VERSION );

	
	
	// Home page styles
	if ( is_front_page() || is_home() ) {
		wp_enqueue_style( 'vbrand-home', $template_dir_uri . '/assets/styles/home.css', array( 'vbrand-footer' ), _S_VERSION );
		wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11' );
		wp_enqueue_style( 'vbrand-main-services', $template_dir_uri . '/assets/styles/mainServices.css', array( 'vbrand-home', 'swiper' ), _S_VERSION );
		wp_enqueue_style( 'vbrand-main-review', $template_dir_uri . '/assets/styles/mainReview.css', array( 'vbrand-home', 'swiper' ), _S_VERSION );
		wp_enqueue_style( 'vbrand-main-blog', $template_dir_uri . '/assets/styles/mainBlog.css', array( 'vbrand-home', 'swiper' ), _S_VERSION );
	}

	// Services archive and single
	if ( is_post_type_archive( 'services' ) || is_singular( 'services' ) || is_tax( 'service_category' ) || is_tax( 'service_tag' ) ) {
		wp_enqueue_style( 'vbrand-services', $template_dir_uri . '/assets/styles/services.css', array( 'vbrand-global' ), _S_VERSION );
	}

	// Blog archive and single
	if ( is_post_type_archive( 'blog' ) || is_singular( 'blog' ) || is_tax( 'blog_category' ) || is_tax( 'blog_tag' ) ) {
		wp_enqueue_style( 'vbrand-blog', $template_dir_uri . '/assets/styles/blog.css', array( 'vbrand-global' ), _S_VERSION );
	}

	// Search results page
	if ( is_search() ) {
		wp_enqueue_style( 'vbrand-search', $template_dir_uri . '/assets/styles/search.css', array( 'vbrand-global' ), _S_VERSION );
	}

	// Page About template
	if ( is_page_template( 'templates/page-about.php' ) ) {
		wp_enqueue_style( 'vbrand-page-about', $template_dir_uri . '/assets/styles/pageAbout.css', array( 'vbrand-global' ), _S_VERSION );
	}

		// Page Contact template
		if ( is_page_template( 'templates/page-contact.php' ) ) {
			wp_enqueue_style( 'vbrand-page-contact', $template_dir_uri . '/assets/styles/pageContact.css', array( 'vbrand-global' ), _S_VERSION );
		}
	
}
add_action( 'wp_enqueue_scripts', 'vbrand_custom_scripts' );


<?php
/**
 * vbrand_custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vbrand_custom
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function vbrand_custom_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'vbrand_custom' ),
		)
	);

	// Switch default core markup to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'vbrand_custom_setup' );

/**
 * Скрыть стандартные записи из меню админки
 */
function vbrand_remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'vbrand_remove_default_post_type' );

/**
 * Load theme styles
 */
require get_template_directory() . '/inc/enqueue-styles.php';

/**
 * Load theme scripts
 */
require get_template_directory() . '/inc/enqueue-scripts.php';

/**
 * Load theme scripts
 */
require get_template_directory() . '/inc/global-form.php';

/**
 * Load services CPT
 */
require get_template_directory() . '/inc/services.php';

/**
 * Load search functionality
 */
require get_template_directory() . '/inc/search.php';

/**
 * Load blog CPT
 */
require get_template_directory() . '/inc/blog.php';
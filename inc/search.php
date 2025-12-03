<?php
/**
 * Search functionality
 *
 * @package vbrand_custom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Расширяем поиск на все типы постов
 */
function vbrand_extend_search( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_search() ) {
            // Исключаем только служебные типы постов
            $query->set( 'post_type', array( 'post', 'page', 'services' ) );
        }
    }
}
add_action( 'pre_get_posts', 'vbrand_extend_search' );

/**
 * Улучшаем поиск - ищем по заголовку, содержимому и excerpt
 */
function vbrand_search_excerpt( $where, $wp_query ) {
    global $wpdb;
    
    if ( $wp_query->is_search() && ! is_admin() ) {
        $search_term = $wp_query->get( 's' );
        if ( ! empty( $search_term ) ) {
            $where = preg_replace(
                "/\(({$wpdb->posts}.post_title)\s+LIKE\s*('[^']+')\)/",
                "($1 LIKE $2) OR ({$wpdb->posts}.post_excerpt LIKE $2) OR ({$wpdb->posts}.post_content LIKE $2)",
                $where
            );
        }
    }
    return $where;
}
add_filter( 'posts_where', 'vbrand_search_excerpt', 10, 2 );



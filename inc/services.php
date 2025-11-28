<?php
/**
 * Custom Post Type: Services (Услуги)
 */

// Регистрация CPT
function vbrand_register_services_cpt() {
    $labels = array(
        'name'               => 'Услуги',
        'singular_name'      => 'Услуга',
        'menu_name'          => 'Услуги',
        'add_new'            => 'Добавить услугу',
        'add_new_item'       => 'Добавить новую услугу',
        'edit_item'          => 'Редактировать услугу',
        'new_item'           => 'Новая услуга',
        'view_item'          => 'Просмотреть услугу',
        'search_items'       => 'Искать услуги',
        'not_found'          => 'Услуги не найдены',
        'not_found_in_trash' => 'В корзине услуг не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'services' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => false,
    );

    register_post_type( 'services', $args );
}
add_action( 'init', 'vbrand_register_services_cpt' );

// Регистрация таксономии (категории услуг)
function vbrand_register_services_taxonomy() {
    $labels = array(
        'name'              => 'Категории услуг',
        'singular_name'     => 'Категория',
        'search_items'      => 'Искать категории',
        'all_items'         => 'Все категории',
        'parent_item'       => 'Родительская категория',
        'parent_item_colon' => 'Родительская категория:',
        'edit_item'         => 'Редактировать категорию',
        'update_item'       => 'Обновить категорию',
        'add_new_item'      => 'Добавить категорию',
        'new_item_name'     => 'Название новой категории',
        'menu_name'         => 'Категории',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'service-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'service_category', array( 'services' ), $args );
}
add_action( 'init', 'vbrand_register_services_taxonomy' );

// Регистрация тегов для услуг
function vbrand_register_services_tags() {
    $labels = array(
        'name'              => 'Теги услуг',
        'singular_name'     => 'Тег',
        'search_items'      => 'Искать теги',
        'all_items'         => 'Все теги',
        'edit_item'         => 'Редактировать тег',
        'update_item'       => 'Обновить тег',
        'add_new_item'      => 'Добавить тег',
        'new_item_name'     => 'Название нового тега',
        'menu_name'         => 'Теги',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'service-tag' ),
        'show_in_rest'      => false,
    );

    register_taxonomy( 'service_tag', array( 'services' ), $args );
}
add_action( 'init', 'vbrand_register_services_tags' );

// Загрузка шаблонов из папки templates
function vbrand_services_templates( $template ) {
    if ( is_post_type_archive( 'services' ) || is_tax( 'service_category' ) || is_tax( 'service_tag' ) ) {
        $custom_template = get_template_directory() . '/templates/archive-services.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }
    
    if ( is_singular( 'services' ) ) {
        $custom_template = get_template_directory() . '/templates/single-services.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter( 'template_include', 'vbrand_services_templates' );


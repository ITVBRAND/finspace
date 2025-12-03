<?php
/**
 * Custom Post Type: Blog (Блог)
 */

// Регистрация CPT
function vbrand_register_blog_cpt() {
    $labels = array(
        'name'               => 'Блог',
        'singular_name'      => 'Запись блога',
        'menu_name'          => 'Блог',
        'add_new'            => 'Добавить запись',
        'add_new_item'       => 'Добавить новую запись',
        'edit_item'          => 'Редактировать запись',
        'new_item'           => 'Новая запись',
        'view_item'          => 'Просмотреть запись',
        'search_items'       => 'Искать записи',
        'not_found'          => 'Записи не найдены',
        'not_found_in_trash' => 'В корзине записей не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'blog' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-edit',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => false,
    );

    register_post_type( 'blog', $args );
}
add_action( 'init', 'vbrand_register_blog_cpt' );

// Регистрация таксономии (категории блога)
function vbrand_register_blog_taxonomy() {
    $labels = array(
        'name'              => 'Категории блога',
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
        'rewrite'           => array( 'slug' => 'blog-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'blog_category', array( 'blog' ), $args );
}
add_action( 'init', 'vbrand_register_blog_taxonomy' );

// Регистрация тегов для блога
function vbrand_register_blog_tags() {
    $labels = array(
        'name'              => 'Теги блога',
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
        'rewrite'           => array( 'slug' => 'blog-tag' ),
        'show_in_rest'      => false,
    );

    register_taxonomy( 'blog_tag', array( 'blog' ), $args );
}
add_action( 'init', 'vbrand_register_blog_tags' );

// Загрузка шаблонов из папки templates
function vbrand_blog_templates( $template ) {
    // Для архивов блога и таксономий
    if ( is_post_type_archive( 'blog' ) || is_tax( 'blog_category' ) || is_tax( 'blog_tag' ) ) {
        $custom_template = get_template_directory() . '/templates/archive-blog.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }
    
    // Для одиночных записей блога
    if ( is_singular( 'blog' ) ) {
        $custom_template = get_template_directory() . '/templates/single-blog.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter( 'template_include', 'vbrand_blog_templates', 99 );


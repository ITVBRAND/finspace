<?php
/**
 * The template for displaying search results
 *
 * @package vbrand_custom
 */

// Подключаем шаблон из папки templates
$template = locate_template( 'templates/search-result.php' );
if ( $template ) {
    load_template( $template );
} else {
    // Fallback на стандартный шаблон
    get_header();
    ?>
    <main class="page">
        <div class="container">
            <h1><?php printf( esc_html__( 'Результаты поиска для: %s', 'vbrand_custom' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
                    the_excerpt();
                endwhile;
            else :
                echo '<p>' . esc_html__( 'Ничего не найдено.', 'vbrand_custom' ) . '</p>';
            endif;
            ?>
        </div>
    </main>
    <?php
    get_footer();
}



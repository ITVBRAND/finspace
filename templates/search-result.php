<?php
/**
 * Template for displaying search results
 *
 * @package vbrand_custom
 */

get_header();
?>

<main class="page search-results">
    <div class="container">
        <section class="section search-results__section">
            <h1 class="search-results__title">
                <?php
                printf(
                    esc_html__( 'Результаты поиска для: %s', 'vbrand_custom' ),
                    '<span class="search-query">' . esc_html( get_search_query() ) . '</span>'
                );
                ?>
            </h1>

            <?php if ( have_posts() ) : ?>
                <div class="search-results__count">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html( _n( 'Найдено результатов: %d', 'Найдено результатов: %d', $wp_query->found_posts, 'vbrand_custom' ) ),
                        $wp_query->found_posts
                    );
                    ?>
                </div>

                <div class="search-results__list">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="search-results__item">
                            <div class="search-results__item-header">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="search-results__thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'medium', array( 'class' => 'search-results__img' ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="search-results__content">
                                    <h2 class="search-results__item-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="search-results__meta">
                                        <span class="search-results__type">
                                            <?php
                                            $post_type_obj = get_post_type_object( get_post_type() );
                                            echo esc_html( $post_type_obj->labels->singular_name );
                                            ?>
                                        </span>
                                        <?php if ( get_post_type() === 'services' ) : ?>
                                            <?php
                                            $categories = get_the_terms( get_the_ID(), 'service_category' );
                                            if ( $categories && ! is_wp_error( $categories ) ) :
                                                ?>
                                                <span class="search-results__category">
                                                    <?php echo esc_html( $categories[0]->name ); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="search-results__excerpt">
                                        <?php
                                        if ( has_excerpt() ) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words( get_the_content(), 30, '...' );
                                        }
                                        ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="search-results__link">
                                        Читать далее →
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Пагинация
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '← Назад', 'vbrand_custom' ),
                    'next_text' => __( 'Вперед →', 'vbrand_custom' ),
                ) );
                ?>

            <?php else : ?>
                <div class="search-results__empty">
                    <p class="search-results__empty-text">
                        <?php esc_html_e( 'К сожалению, ничего не найдено. Попробуйте изменить поисковый запрос.', 'vbrand_custom' ); ?>
                    </p>
                    <div class="search-results__search-again">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php
get_footer();



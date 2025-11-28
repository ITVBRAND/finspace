<?php
/**
 * Template Name: Архив услуг
 * Template Post Type: page
 */

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
?>

<main class="page">
    <section class="section services-archive">
        <div class="container">
            <div class="section__services-header">
                <article class="section__article section__article-services">
                    <h1 class="section__title section__title-services">
                        <?php
                        if ( is_tax( 'service_category' ) ) {
                            single_term_title();
                        } elseif ( is_tax( 'service_tag' ) ) {
                            single_term_title();
                        } else {
                            echo 'Наши услуги';
                        }
                        ?>
                    </h1>
                </article>
                <div class="services-archive__tabs">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'services' ) ); ?>" class="services-archive__tab <?php echo ( is_post_type_archive( 'services' ) ) ? 'active' : ''; ?>">
                        Все услуги
                    </a>
                    <?php
                    $service_categories = get_terms( array(
                        'taxonomy'   => 'service_category',
                        'hide_empty' => true,
                    ) );
                    if ( $service_categories && ! is_wp_error( $service_categories ) ) :
                        foreach ( $service_categories as $cat ) :
                            $is_active = ( is_tax( 'service_category', $cat->slug ) ) ? 'active' : '';
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="services-archive__tab <?php echo $is_active; ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="services-archive__grid">
                <?php
                // Для страниц таксономий используем глобальный запрос
                if ( is_tax( 'service_category' ) || is_tax( 'service_tag' ) ) {
                    global $wp_query;
                    $services_query = $wp_query;
                } else {
                    $args = array(
                        'post_type'      => 'services',
                        'posts_per_page' => 18,
                        'paged'          => $paged,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );
                    $services_query = new WP_Query( $args );
                }

                if ( $services_query->have_posts() ) :
                    while ( $services_query->have_posts() ) :
                        $services_query->the_post();
                        $categories = get_the_terms( get_the_ID(), 'service_category' );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="services-archive__item">
                            <div class="services-archive__header">
                                <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                                    <div class="tab">
                                        <p><?php echo esc_html( $categories[0]->name ); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="link-arrow"></div>
                            </div>
                            <h3 class="services-archive__title"><?php the_title(); ?></h3>
                        </a>
                        <?php
                    endwhile;
                else :
                    ?>
                    <p>Услуги не найдены.</p>
                <?php endif; ?>
            </div>

            <?php if ( $services_query->max_num_pages > 1 ) : ?>
            <div class="pagination">
                <?php
                echo paginate_links( array(
                    'total'     => $services_query->max_num_pages,
                    'current'   => $paged,
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type'      => 'list',
                ) );
                ?>
            </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php
get_footer();

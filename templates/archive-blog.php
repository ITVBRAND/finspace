<?php
/**
 * Template Name: Архив блога
 * Template Post Type: page
 */

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
?>

<main class="page">
    <section class="section blog-archive">
        <div class="container">
            <div class="section__blog-header">
                <article class="section__article section__article-blog">
                    <h1 class="section__title section__title-blog">
                        <?php
                        if ( is_tax( 'blog_category' ) ) {
                            single_term_title();
                        } elseif ( is_tax( 'blog_tag' ) ) {
                            single_term_title();
                        } else {
                            echo 'Блог';
                        }
                        ?>
                    </h1>
                </article>
                <div class="blog-archive__tabs">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'blog' ) ); ?>" class="blog-archive__tab <?php echo ( is_post_type_archive( 'blog' ) ) ? 'active' : ''; ?>">
                        Все записи
                    </a>
                    <?php
                    $blog_categories = get_terms( array(
                        'taxonomy'   => 'blog_category',
                        'hide_empty' => true,
                    ) );
                    if ( $blog_categories && ! is_wp_error( $blog_categories ) ) :
                        foreach ( $blog_categories as $cat ) :
                            $is_active = ( is_tax( 'blog_category', $cat->slug ) ) ? 'active' : '';
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="blog-archive__tab <?php echo $is_active; ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="blog-archive__grid">
                <?php
                // Для страниц таксономий используем глобальный запрос
                if ( is_tax( 'blog_category' ) || is_tax( 'blog_tag' ) ) {
                    global $wp_query;
                    $blog_query = $wp_query;
                } else {
                    $args = array(
                        'post_type'      => 'blog',
                        'posts_per_page' => 18,
                        'paged'          => $paged,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );
                    $blog_query = new WP_Query( $args );
                }

                if ( $blog_query->have_posts() ) :
                    while ( $blog_query->have_posts() ) :
                        $blog_query->the_post();
                        $categories = get_the_terms( get_the_ID(), 'blog_category' );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="blog__item">
                            <div class="blog__item-wrapper">
                                <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                                    <div class="blog__tabs">
                                        <div class="blog__tab"><?php echo esc_html( $categories[0]->name ); ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="blog__images">
                                        <?php the_post_thumbnail( 'medium', array( 'class' => 'blog__images-img' ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <article class="blog__article">
                                <p class="blog__date">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </p>
                                <h3 class="blog__title">
                                    <?php 
                                    $title = get_the_title();
                                    if ( mb_strlen( $title ) > 110 ) {
                                        echo esc_html( mb_substr( $title, 0, 52 ) ) . '...';
                                    } else {
                                        echo esc_html( $title );
                                    }
                                    ?>
                                </h3>
                            </article>
                        </a>

                        <?php
                    endwhile;
                else :
                    ?>
                    <p>Записи не найдены.</p>
                <?php endif; ?>
            </div>

            <?php if ( $blog_query->max_num_pages > 1 ) : ?>
            <div class="pagination">
                <?php
                echo paginate_links( array(
                    'total'     => $blog_query->max_num_pages,
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


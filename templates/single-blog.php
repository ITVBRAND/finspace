<?php
/**
 * Template for single blog post
 */

get_header();
?>

<main class="single-blog">
    <div class="container">
        <article class="single-blog__article">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <header class="single-blog__header">
                    <?php
                    $categories = get_the_terms( get_the_ID(), 'blog_category' );
                    if ( $categories && ! is_wp_error( $categories ) ) :
                        ?>
                        <div class="single-blog__categories">
                            <?php foreach ( $categories as $cat ) : ?>
                                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="single-blog__category">
                                    <?php echo esc_html( $cat->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="single-blog__title"><?php the_title(); ?></h1>
                    
                    <div class="single-blog__meta">
                        <time class="single-blog__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_the_date() ); ?>
                        </time>
                        <?php if ( get_the_author() ) : ?>
                            <span class="single-blog__author">
                                Автор: 
                                <?php
                                    $author_first = get_the_author_meta('first_name');
                                    $author_last = get_the_author_meta('last_name');

                                    if (empty($author_first) && empty($author_last)) {
                                        // Если нет имени и фамилии, выводим логин
                                        echo esc_html(get_the_author());
                                    } else {
                                        // Выводим имя и фамилию
                                        echo esc_html(trim($author_first . ' ' . $author_last));
                                    }
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-blog__thumbnail">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="single-blog__content">
                    <?php the_content(); ?>
                </div>

                <?php
                $tags = get_the_terms( get_the_ID(), 'blog_tag' );
                if ( $tags && ! is_wp_error( $tags ) ) :
                    ?>
                    <footer class="single-blog__footer">
                        <div class="single-blog__tags">
                            <span class="single-blog__tags-label">Теги:</span>
                            <?php foreach ( $tags as $tag ) : ?>
                                <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="single-blog__tag">
                                    <?php echo esc_html( $tag->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </footer>
                <?php endif; ?>

                <?php
            endwhile;
            ?>
        </article>
    </div>
</main>

<?php
get_footer();


<?php
/**
 * Template for single service
 */

get_header();
?>

<!-- <main class="page">
    <section class="section service-single">
        <div class="container">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
                <article class="service-single__content">
                    <div class="service-single__header">
                        <?php
                        $categories = get_the_terms( get_the_ID(), 'service_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) :
                        ?>
                            <div class="tab">
                                <p><?php echo esc_html( $categories[0]->name ); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="service-single__title"><?php the_title(); ?></h1>
                    </div>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="service-single__thumbnail">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="service-single__body">
                        <?php the_content(); ?>
                    </div>

                    <div class="service-single__cta">
                        <button class="btn btn-default js-modal-contact">Оставить заявку</button>
                        <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn-link">Все услуги</a>
                    </div>
                </article>

            <?php endwhile; endif; ?>
        </div>
    </section>
</main> -->

<main class="single-services">
    <div class="container">
        <section class="section single-banner">
            <a href="#" class="single-link">
                <picture class="single-banner__picture">
                    <source srcset="" media="(min-width: 768px)" />
                    <img class="single-banner__img" src="" alt="" />
                </picture>
            </a>
        </section>
        <section class="section single-advantage">
            <div class="single-advantage__list">
                <article class="single-advantage__item">
                    <h3 class="single-advantage__title">
                        Подготовим все документы
                    </h3>
                    <p class="single-advantage__subtitle">
                        Нужен только паспорт и СНИЛС
                    </p>
                </article>
                <article class="single-advantage__item">
                    <h3 class="single-advantage__title">
                        Подготовим все документы
                    </h3>
                    <p class="single-advantage__subtitle">
                        Нужен только паспорт и СНИЛС
                    </p>
                </article>
                <article class="single-advantage__item">
                    <h3 class="single-advantage__title">
                        Подготовим все документы
                    </h3>
                    <p class="single-advantage__subtitle">
                        Нужен только паспорт и СНИЛС
                    </p>
                </article>
                <article class="single-advantage__item">
                    <h3 class="single-advantage__title">
                        Подготовим все документы
                    </h3>
                    <p class="single-advantage__subtitle">
                        Нужен только паспорт и СНИЛС
                    </p>
                </article>
            </div>
        </section>
        <section class="section single-work">
            <h2 class="single-work__title">
                Что сделаем?
            </h2>
            <div class="single-work__list">
                
            </div>
        </section>
    </div>
</main>

<?php
get_footer();


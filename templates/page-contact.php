<?php
/**
 * Template Name: "Шаблон страницы Контакты"
 * Description: Шаблон для пользовательской страницы
 */
?>
<?php get_header(); ?>
<div class="container">
    <div class="page-contact">
        <article class="contact__header">
            <h1 class="contact__header-title">
                Контакты
            </h1>
        </article>
        <div class="contact__wrap">
            <div class="contact__info">
                <div class="contact__info-row">
                    <div class="contact__info-col">
                        <!--Адрес-->
                        <?php if( have_rows('option_addres_repeater', 'option') ): ?>
                            <?php while( have_rows('option_addres_repeater', 'option') ): the_row(); ?>
                                <div class="contact__info-item">
                                    <p class="contact__info-title">
                                        <?php the_sub_field('option_addres_title', 'option'); ?>
                                    </p>
                                    <a href="<?php the_sub_field('option_addres_link', 'option'); ?>" class="contact__info-link">
                                        <?php the_sub_field('option_addres_text', 'option'); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <!--Режим работы-->
                        <?php if ( function_exists('get_field') && get_field("option_timer", "option") ): ?>
                            <div class="contact__info-item">
                                <p class="contact__info-title">
                                    Режим работы:
                                </p>
                                <p class="contact__info-link">
                                    <?php if ( function_exists('the_field') ) the_field("option_timer", "option"); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="contact__info-col">
                        <!--Телефон-->
                        <?php if ( function_exists('have_rows') && have_rows('option_tel_repeater', 'option') ): ?>
                            <?php while ( have_rows('option_tel_repeater', 'option') ): the_row(); ?>
                                <?php 
                                    $tel_name = get_sub_field('option_tel_name');
                                    $tel_link = get_sub_field('option_tel_link');
                                ?>
                                <div class="contact__info-item">
                                    <p class="contact__info-title">
                                        <?php echo esc_html( $tel_name ); ?>
                                    </p>
                                    <a href="tel:<?php echo esc_attr( preg_replace('/[^+0-9]/', '', $tel_link) ); ?>" class="contact__info-link">
                                        <?php echo esc_html( $tel_link ); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <!--Email-->
                        <?php if ( function_exists('get_field') && get_field("option_default_mail", "option") ): ?>
                            <div class="contact__info-item">
                                <p class="contact__info-title">
                                    Email:
                                </p>
                                <a href="mailto:<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>" class="contact__info-link">
                                    <?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="contact__info-row">
                    <?php if ( function_exists('get_field') && get_field("option_social_repeater", "option") ): ?>
                        <div class="contact__social-list">
                            <?php if ( function_exists('have_rows') && have_rows('option_social_repeater', 'option') ): ?>
                                <?php while ( have_rows('option_social_repeater', 'option') ): the_row(); ?>
                                    <?php 
                                        $social_link = get_sub_field('option_social_link');
                                        $social_icon = get_sub_field('option_social_icon');
                                        $icon_url    = '';

                                        if ( is_array($social_icon) && ! empty($social_icon['url']) ) {
                                            $icon_url = $social_icon['url'];
                                        } elseif ( is_numeric($social_icon) ) {
                                            $icon_url = wp_get_attachment_image_url( intval($social_icon), 'full' );
                                        } elseif ( is_string($social_icon) ) {
                                            $icon_url = $social_icon;
                                        }
                                    ?>
                                    <?php if ( $social_link && $icon_url ): ?>
                                        <a href="<?php echo esc_url( $social_link ); ?>" class="contact__social-item" target="_blank" rel="noopener noreferrer">
                                            <img src="<?php echo esc_url( $icon_url ); ?>" class="contact__social-img" alt="social icon">
                                        </a>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="contact__info-row">
                    <div class="contact__info-col">
                        <article class="contact__info-article">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores, facere?</p>
                        </article>
                        <button class="btn-link contact__info-btn js-modal-contact">Связаться с нами</button>
                    </div>
                </div>
            </div>
            <iframe
                class="contact__maps"
                src="https://yandex.ru/map-widget/v1/?um=constructor%3A500199f6dfdd74920df30b5c0d027dc678e518f1edc49dbb56b716ee8abf8d1c&amp;source=constructor"
                width="960"
                height="420"
                frameborder="0">
            </iframe>
        </div>
    </div>
</div>
<?php get_footer();?>
<?php
/**
 * The template for displaying the footer
 *
 * @package vbrand_custom
 */
?>

<footer class="footer">
    <div class="footer__wras">
        <div class="footer__block">
            <div class="footer__wrap">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/picture/logo_footer.svg" alt="Finspace" class="footer__logo">
                <article class="footer__article">
                    <h3 class="footer__title">
                        Оставьте заявку
                    </h3>
                    <p class="footer__subtitle">
                        Получите профессиональную консультацию
                    </p>
                    <button class="btn js-modal-contact footer__btn">Написать</button>
                </article>
                <h3 class="footer__nav-title">
                    Документация
                </h3>
                <nav class="footer__nav">
                    <a href="#" class="footer__link">
                        Политика конфиденциальности
                    </a>
                    <a href="#" class="footer__link">
                        Обработка персональных данных
                    </a>
                    <a href="#" class="footer__link">
                        Куки
                    </a>
                    <a href="#" class="footer__link">
                        Рассылки
                    </a>
                </nav>
            </div>
            <div class="footer__wrapper">
                <h3 class="footer__nav-title">
                    Навигация
                </h3>
                <nav class="footer__nav">
                    <?php
                        if ( function_exists('have_rows') && ( have_rows('nav_link_add', 'option') || have_rows('nav_link_add') ) ) {
                            // сначала пробуем опции сайта
                            if ( have_rows('nav_link_add', 'option') ) {
                                while ( have_rows('nav_link_add', 'option') ) { the_row();
                                    $link_name = trim( (string) get_sub_field('nav_link_name') );
                                    $link_url  = (string) get_sub_field('nav_link');
                                    if ( $link_name && $link_url ) {
                                        echo '<a href="' . esc_url( $link_url ) . '" class="footer__link">' . esc_html( $link_name ) . '</a>';
                                    }
                                }
                            }
                        }
                    ?>
                </nav>
            </div>
            <div class="footer__wrapper">
                <h3 class="footer__nav-title">
                    Услуги
                </h3>
                <nav class="footer__nav">
                    <?php
                    $service_categories = get_terms( array(
                        'taxonomy'   => 'service_category',
                        'hide_empty' => false,
                    ) );
                    if ( $service_categories && ! is_wp_error( $service_categories ) ) :
                        foreach ( $service_categories as $cat ) :
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="footer__link">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </nav>
            </div>
            <div class="footer__wrapper">
                <h3 class="footer__nav-title">
                    Контакты
                </h3>
                <div class="footer__contact">
                    <div class="footer__contact-nav">
                        <?php if ( function_exists('have_rows') && have_rows('option_tel_repeater', 'option') ): ?>
                            <?php while ( have_rows('option_tel_repeater', 'option') ): the_row(); ?>
                                <?php 
                                    $tel_name = get_sub_field('option_tel_name');
                                    $tel_link = get_sub_field('option_tel_link');
                                ?>
                                <div class="header__contact-item">
                                    <p class="header__contact-item title footer__subtitle">
                                        <?php echo esc_html( $tel_name ); ?>
                                    </p>
                                    <a href="tel:<?php echo esc_attr( preg_replace('/[^+0-9]/', '', $tel_link) ); ?>" class="footer__link">
                                        <?php echo esc_html( $tel_link ); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if ( function_exists('get_field') && get_field("option_default_mail", "option") ): ?>
                            <div class="header__contact-item">
                                <p class="header__contact-item title footer__subtitle">
                                    Email:
                                </p>
                                <a href="mailto:<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>" class="footer__link">
                                    <?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if( have_rows('option_addres_repeater', 'option') ): ?>
                            <?php while( have_rows('option_addres_repeater', 'option') ): the_row(); ?>
                                <div class="header__contact-item">
                                    <p class="header__contact-item title footer__subtitle">
                                        <?php the_sub_field('option_addres_title', 'option'); ?>
                                    </p>
                                    <a href="<?php the_sub_field('option_addres_link', 'option'); ?>" class="footer__link">
                                        <?php the_sub_field('option_addres_text', 'option'); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if ( function_exists('get_field') && get_field("option_timer", "option") ): ?>
                            <div class="header__contact-item">
                                <p class="header__contact-item title footer__subtitle">
                                    Режим работы:
                                </p>
                                <p class="footer__link">
                                    <?php if ( function_exists('the_field') ) the_field("option_timer", "option"); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <?php if ( function_exists('get_field') && get_field("option_social_repeater", "option") ): ?>
                            <div class="header__contact-item">
                                <p class="header__contact-item title footer__subtitle">
                                    Мы в соц. сетях:
                                </p>
                                <div class="header__contact-social list">
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
                                                <a href="<?php echo esc_url( $social_link ); ?>" class="footer__link" target="_blank" rel="noopener noreferrer">
                                                    <img src="<?php echo esc_url( $icon_url ); ?>" class="footer__social-img" alt="social icon">
                                                </a>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <p class="footer__copyright">
                Copyright © 2025 ООО “ФИНСПЕЙС” | Все права защищены
            </p>
            <div class="footer__dev">
                <p class="footer__dev-text">
                    сайт разработан маркетинговым агентством
                </p>
                <a class="vbrand" href="https://vbrand.ru/?utm_source=finspace&utm_medium=cpc&utm_content=link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/picture/v-brand_logo.webp" alt="разработка сайтов в Ростове-на-Дону v-brand">
                </a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<?php get_template_part('template-parts/modal-contact'); ?>

<!-- BEGIN CONVERSUS -->
<script type="text/javascript">
  (function(i,s,o,g,a,m,id=6300){
    i["PVWatcherObj"]={ver:1.01};
    a=s.createElement(o);
    Object.assign(a,{PVWatcherID:id,async:1,src:g+"?"+(new Date).getTime()});
    m=s.getElementsByTagName(o)[0];
    m.parentNode.insertBefore(a,m);
  })(window,document,"script","//lk.conversus.pro/smartvoronka/watcher-prod/pv.temporary.js");
</script>
<!-- END CONVERSUS -->

 <!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104686133', 'ym');

    ym(104686133, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/104686133" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>

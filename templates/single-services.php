<?php
/**
 * Template for single service
 */

get_header();
?>

<main class="single-services">
    <div class="container">
        <?php 
        // Проверяем наличие гибкого содержимого services_constructor
        if ( function_exists('have_rows') && have_rows('services_constructor') ) :
            while ( have_rows('services_constructor') ) : the_row();
                
                // Обработка макета services_banner
                if ( get_row_layout() == 'services_banner' ) :
                    $banner_img_pc = get_sub_field('banner_img_pc');
                    $banner_img_mob = get_sub_field('banner_img_mob');
                    $banner_link = get_sub_field('banner_link');
                    
                    // Проверяем наличие хотя бы одного изображения
                    if ( $banner_img_pc || $banner_img_mob ) :
                        // Получаем URL изображений
                        $img_pc_url = '';
                        $img_mob_url = '';
                        
                        if ( $banner_img_pc ) {
                            if ( is_array($banner_img_pc) && !empty($banner_img_pc['url']) ) {
                                $img_pc_url = $banner_img_pc['url'];
                            } elseif ( is_numeric($banner_img_pc) ) {
                                $img_pc_url = wp_get_attachment_image_url( intval($banner_img_pc), 'full' );
                            } elseif ( is_string($banner_img_pc) ) {
                                $img_pc_url = $banner_img_pc;
                            }
                        }
                        
                        if ( $banner_img_mob ) {
                            if ( is_array($banner_img_mob) && !empty($banner_img_mob['url']) ) {
                                $img_mob_url = $banner_img_mob['url'];
                            } elseif ( is_numeric($banner_img_mob) ) {
                                $img_mob_url = wp_get_attachment_image_url( intval($banner_img_mob), 'full' );
                            } elseif ( is_string($banner_img_mob) ) {
                                $img_mob_url = $banner_img_mob;
                            }
                        }
                        
                        // Если нет мобильного изображения, используем десктопное
                        if ( !$img_mob_url && $img_pc_url ) {
                            $img_mob_url = $img_pc_url;
                        }
                        // Если нет десктопного изображения, используем мобильное
                        if ( !$img_pc_url && $img_mob_url ) {
                            $img_pc_url = $img_mob_url;
                        }
                        
                        // Получаем alt текст
                        $img_alt = '';
                        if ( $banner_img_pc && is_array($banner_img_pc) && !empty($banner_img_pc['alt']) ) {
                            $img_alt = $banner_img_pc['alt'];
                        } elseif ( $banner_img_mob && is_array($banner_img_mob) && !empty($banner_img_mob['alt']) ) {
                            $img_alt = $banner_img_mob['alt'];
                        }
                        if ( !$img_alt ) {
                            $img_alt = get_the_title();
                        }
                        ?>
                        <section class="section single-banner">
                            <?php if ( $banner_link ) : ?>
                                <a href="<?php echo esc_url( $banner_link ); ?>" class="single-link">
                            <?php else : ?>
                                <div class="single-link">
                            <?php endif; ?>
                                <picture class="single-banner__picture">
                                    <?php if ( $img_pc_url ) : ?>
                                        <source srcset="<?php echo esc_url( $img_pc_url ); ?>" media="(min-width: 768px)" />
                                    <?php endif; ?>
                                    <?php if ( $img_mob_url ) : ?>
                                        <img class="single-banner__img" src="<?php echo esc_url( $img_mob_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
                                    <?php endif; ?>
                                </picture>
                            <?php if ( $banner_link ) : ?>
                                </a>
                            <?php else : ?>
                                </div>
                            <?php endif; ?>
                        </section>
                        <?php
                    endif; // Конец проверки наличия изображений
                
                
                    // Обработка макета section_advantage
                elseif ( get_row_layout() == 'section_advantage' ) :
                    // Проверяем наличие повторителя advantage_item
                    if ( have_rows('advantage_item') ) :
                        ?>
                        <section class="single-advantage">
                            <div class="single-advantage__list">
                                <?php while ( have_rows('advantage_item') ) : the_row();
                                    $advantage_title = get_sub_field('advantage_title');
                                    $advantage_subtitle = get_sub_field('advantage_subtitle');
                                    
                                    // Выводим элемент только если есть хотя бы заголовок
                                    if ( $advantage_title || $advantage_subtitle ) :
                                        ?>
                                        <article class="single-advantage__item">
                                            <?php if ( $advantage_title ) : ?>
                                                <h3 class="single-advantage__title">
                                                    <?php echo esc_html( $advantage_title ); ?>
                                                </h3>
                                            <?php endif; ?>
                                            <?php if ( $advantage_subtitle ) : ?>
                                                <p class="single-advantage__subtitle">
                                                    <?php echo esc_html( $advantage_subtitle ); ?>
                                                </p>
                                            <?php endif; ?>
                                        </article>
                                        <?php
                                    endif;
                                endwhile; ?>
                            </div>
                        </section>
                        <?php
                    endif; // Конец проверки повторителя advantage_item
                
                // Обработка макета services_work
                elseif ( get_row_layout() == 'services_work' ) :
                    $services_title = get_sub_field('services_title');
                    
                    // Проверяем наличие повторителя services_item
                    if ( have_rows('services_item') ) :
                        // Начинаем вывод секции
                        ?>
                        <section class="section single-work">
                            <?php if ( $services_title ) : ?>
                                <h2 class="single-work__title">
                                    <?php echo esc_html( $services_title ); ?>
                                </h2>
                            <?php endif; ?>
                            <div class="single-work__list">
                                <?php 
                                $item_number = 1;
                                while ( have_rows('services_item') ) : the_row();
                                    $services_content = get_sub_field('services_content');
                                    
                                    // Выводим элемент только если есть контент
                                    if ( $services_content ) :
                                        ?>
                                        <div class="single-work__item">
                                            <span class="single-work__number"><?php echo esc_html( $item_number ); ?></span>
                                            <article class="single-work__article">
                                                <?php echo wp_kses_post( wpautop( $services_content ) ); ?>
                                            </article>
                                        </div>
                                        <?php
                                        $item_number++;
                                    endif;
                                endwhile; ?>
                            </div>
                        </section>
                        <?php
                    endif; // Конец проверки повторителя services_item
                
                // Обработка макета services_form
                elseif ( get_row_layout() == 'services_form' ) :
                    // Получаем поля формы из ACF
                    $form_title = get_sub_field('services_title');
                    $form_subtitle = get_sub_field('services_subtitle');
                    
                    // Получаем название услуги для формы
                    $service_title = '';
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            $service_title = get_the_title();
                        }
                        wp_reset_postdata();
                    } else {
                        // Fallback: получаем из queried object
                        $queried_object = get_queried_object();
                        if ( $queried_object && isset( $queried_object->post_title ) ) {
                            $service_title = $queried_object->post_title;
                        }
                    }
                    ?>
                    <section class="section single-form">
                        <article class="single-form__article">
                            <?php if ( $form_title ) : ?>
                                <h2 class="single-form__title">
                                    <?php echo esc_html( $form_title ); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if ( $form_subtitle ) : ?>
                                <p class="single-form__subtitle">
                                    <?php echo esc_html( $form_subtitle ); ?>
                                </p>
                            <?php endif; ?>
                        </article>
                        <form class="single-form__form" data-service-name="<?php echo esc_attr( $service_title ); ?>">
                            <div class="single-form__wrap">
                                <div class="single-form__input__wrap">
                                    <label for="phone">Телефон:</label>
                                    <input type="tel" name="phone" id="phone" placeholder="+7 (999) 999 99-99" required>
                                </div>
                                <div class="single-form__checkbox-wrap">
                                    <input type="checkbox" name="privacy" id="privacy" required>
                                    <label for="privacy">Отправляя заявку, вы соглашаетесь на <a href="#">обработку персональных данных</a> и с <a href="#">политикой конфиденциальности</a></label>
                                </div>
                                <button class="single-form__btn" type="submit">Отправить заявку</button>
                            </div>
                        </form>
                    </section>
                    <?php
                
                // Обработка макета services_faq
                elseif ( get_row_layout() == 'services_faq' ) :
                    // Проверяем наличие повторителя repeat_question
                    if ( have_rows('repeat_question') ) :
                        ?>
                        <section class="section single-faq">
                            <h2 class="single-faq__title">
                                Часто задаваемые вопросы?
                            </h2>
                            <div class="faq__accordion">
                                <div class="faq__accordion-list">
                                    <?php while ( have_rows('repeat_question') ) : the_row();
                                        $question_title = get_sub_field('question_title');
                                        $question_subtitle = get_sub_field('question_subtitle');
                                        
                                        // Выводим элемент только если есть хотя бы заголовок
                                        if ( $question_title || $question_subtitle ) :
                                            ?>
                                            <div class="faq__accordion-item">
                                                <div class="faq__accordion-header">
                                                    <?php if ( $question_title ) : ?>
                                                        <h2 class="faq__accordion-title">
                                                            <?php echo esc_html( $question_title ); ?>
                                                        </h2>
                                                    <?php endif; ?>
                                                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/icons/chevron.svg" alt="шеврон" class="faq__accordion-arrow">
                                                </div>
                                                <?php if ( $question_subtitle ) : ?>
                                                    <div class="faq__accordion-content">
                                                        <p class="faq__accordion-text">
                                                            <?php echo esc_html( $question_subtitle ); ?>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        endif;
                                    endwhile; ?>
                                </div>
                            </div>
                        </section>
                        <?php
                    endif; // Конец проверки повторителя repeat_question
                // Обработка макета services_custom
                elseif ( get_row_layout() == 'services_custom' ) :
                    ?>
                    <section class="section single-custom">
                        <?php the_content(); ?>
                    </section>
                    <?php
                endif; // Конец проверки макета services_custom
                
            endwhile;
        endif; // Конец проверки гибкого содержимого
        ?>
    </div>
</main>

<?php
get_footer();


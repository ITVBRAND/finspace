<?php
/**
 * Template Name: "Шаблон страницы о компании"
 * Description: Шаблон для пользовательской страницы
 */
?>
<?php get_header(); ?>
<div class="container">
    <div class="page-about">
        <div class="about__header">
            <article class="about__header-article">
                <p class="about__header-subtitle">
                    О компании
                </p>
                <h1 class="about__header-title">
                    Ваш успех начинается с правильных цифр
                </h1>
            </article>
            <p class="about__header-text">
                Наша команда работает для того, чтобы ваш бизнес развивался уверенно и без ошибок.
            </p>
        </div>
        <div class="about__body">
            <nav class="about__nav">
                <a href="#about" class="about__nav-link">
                    О компании
                </a>
                <a href="#licence" class="about__nav-link">
                    Лицензии и сертификаты
                </a>
                <a href="#partners" class="about__nav-link">
                    Партнеры
                </a>
                <a href="#client" class="about__nav-link">
                    Клиенты
                </a>
                <a href="#team" class="about__nav-link">
                    Сотрудники
                </a>
                <a href="#work" class="about__nav-link">
                    Работа с нами
                </a>
                <a href="#detail" class="about__nav-link">
                    Реквизиты
                </a>
            </nav>
            <div class="about__content">
                <div class="about__block about__block-about" id="about">
                    <?php 
                        $about_content = get_field( 'about_content', 'option' );
                        if ( ! $about_content ) {
                            $about_content = get_field( 'about_content' );
                        }
                        
                        if ( $about_content ) {
                            echo '<div class="about__content-text">' . wp_kses_post( $about_content ) . '</div>';
                        }
                    ?>
                </div>
                <div class="about__block about__block-licence" id="licence">
                    <article class="about__licence__article">
                        <?php 
                            // Проверяем сначала опции сайта, потом страницу
                            $licence_title = get_field( 'licence_title', 'option' );
                            if ( ! $licence_title ) {
                                $licence_title = get_field( 'licence_title' );
                            }
                            
                            if ( $licence_title ) {
                                echo '<h2 class="about__licence-title">' . esc_html( $licence_title ) . '</h2>';
                            }
                        ?>
                        <?php 
                            // Проверяем сначала опции сайта, потом страницу
                            $licence_subtitle = get_field( 'licence_subtitle', 'option' );
                            if ( ! $licence_subtitle ) {
                                $licence_subtitle = get_field( 'licence_subtitle' );
                            }
                            
                            if ( $licence_subtitle ) {
                                echo '<p class="about__licence-subtitle">' . esc_html( $licence_subtitle ) . '</p>';
                            }
                        ?>
                    </article>
                    <div class="about__licence-list">
                        <?php 
                        // Проверяем сначала опции сайта, потом страницу
                        $repeater_location = null;
                        if ( have_rows( 'licence_repeater', 'option' ) ) {
                            $repeater_location = 'option';
                        } elseif ( have_rows( 'licence_repeater' ) ) {
                            $repeater_location = get_the_ID();
                        }
                        
                        if ( $repeater_location && have_rows( 'licence_repeater', $repeater_location ) ) :
                            while ( have_rows( 'licence_repeater', $repeater_location ) ) : the_row();
                                $title = get_sub_field( 'licence_repeater_title' );
                                $subtitle = get_sub_field( 'licence_repeater_subtitle' );
                                $file = get_sub_field( 'licence_repeater_file' );
                                
                                // Получаем URL файла
                                $file_url = '';
                                if ( $file ) {
                                    if ( is_array( $file ) && isset( $file['url'] ) ) {
                                        $file_url = $file['url'];
                                    } elseif ( is_numeric( $file ) ) {
                                        $file_url = wp_get_attachment_url( $file );
                                    } elseif ( is_string( $file ) ) {
                                        $file_url = $file;
                                    }
                                }
                                
                                $link_href = $file_url ? esc_url( $file_url ) : '#';
                                $link_attrs = $file_url ? 'target="_blank" rel="noopener noreferrer"' : '';
                                $icon_url = esc_url( get_template_directory_uri() . '/assets/icons/file-search.svg' );
                        ?>
                            <a href="<?php echo $link_href; ?>" class="about__licence-item" <?php echo $link_attrs; ?>>
                                <img src="<?php echo $icon_url; ?>" alt="" class="about__licence-img">
                                
                                <article class="about__licence-article">
                                    <?php if ( $title ) : ?>
                                        <h3 class="about__licence-title">
                                            <?php echo esc_html( $title ); ?>
                                        </h3>
                                    <?php endif; ?>
                                    
                                    <?php if ( $subtitle ) : ?>
                                        <p class="about__licence-subtitle">
                                            <?php echo esc_html( $subtitle ); ?>
                                        </p>
                                    <?php endif; ?>
                                </article>
                                
                                <div class="about__licence-icon"></div>
                            </a>
                        <?php 
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
                <div class="about__block about__block-partners" id="partners">
                    <article class="about__licence__article">
                        <?php 
                            $partners_title = get_field( 'partners_title', 'option' ) ?: get_field( 'partners_title' );
                            if ( $partners_title ) {
                                echo '<h2 class="about__licence-title">' . esc_html( $partners_title ) . '</h2>';
                            }
                            
                            $partners_subtitle = get_field( 'partners_subtitle', 'option' ) ?: get_field( 'partners_subtitle' );
                            if ( $partners_subtitle ) {
                                echo '<p class="about__licence-subtitle">' . esc_html( $partners_subtitle ) . '</p>';
                            }
                        ?>
                    </article>
                    
                    <div class="partners__list">
                        <?php 
                            // Проверяем сначала опции, потом страницу
                            $repeater_source = have_rows( 'partners_repeater', 'option' ) ? 'option' : null;
                            if ( ! $repeater_source ) {
                                $repeater_source = have_rows( 'partners_repeater' ) ? get_the_ID() : null;
                            }
                            
                            if ( $repeater_source && have_rows( 'partners_repeater', $repeater_source ) ) :
                                while ( have_rows( 'partners_repeater', $repeater_source ) ) : the_row();
                                    $img = get_sub_field( 'partners_img' );
                                    
                                    if ( ! $img ) continue;
                                    
                                    // Получаем URL и alt изображения
                                    if ( is_array( $img ) ) {
                                        $img_url = $img['url'] ?? '';
                                        $img_alt = $img['alt'] ?? '';
                                    } elseif ( is_numeric( $img ) ) {
                                        $img_url = wp_get_attachment_image_url( $img, 'full' );
                                        $img_alt = get_post_meta( $img, '_wp_attachment_image_alt', true ) ?: '';
                                    } else {
                                        $img_url = $img;
                                        $img_alt = '';
                                    }
                                    
                                    if ( $img_url ) :
                        ?>
                            <div class="partners__item">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" class="partners__img">
                            </div>
                        <?php 
                                    endif;
                                endwhile;
                            endif;
                        ?>
                    </div>
                </div>
                <div class="about__block about__block-client" id="client">
                    <article class="about__licence__article">
                        <h2 class="about__licence-title">
                            <?php the_field('clients_title', 'option'); ?>
                        </h2>
                        <p class="about__licence-subtitle">
                            <?php the_field('clients_subtitle', 'option'); ?>
                        </p>
                    </article>
                    <div class="about__client-list">
                        <?php 
                            $repeater_source = have_rows( 'clients_repeater', 'option' ) ? 'option' : null;
                            if ( ! $repeater_source ) {
                                $repeater_source = have_rows( 'clients_repeater' ) ? get_the_ID() : null;
                            }
                            
                            if ( $repeater_source && have_rows( 'clients_repeater', $repeater_source ) ) :
                                while ( have_rows( 'clients_repeater', $repeater_source ) ) : the_row();
                                    $img = get_sub_field( 'clients_img' );
                                    $title = get_sub_field( 'clients_title' );
                                    
                                    // Получаем URL изображения
                                    if ( $img ) {
                                        if ( is_array( $img ) ) {
                                            $img_url = $img['url'] ?? '';
                                        } elseif ( is_numeric( $img ) ) {
                                            $img_url = wp_get_attachment_image_url( $img, 'full' );
                                        } else {
                                            $img_url = $img;
                                        }
                                    }
                        ?>
                                <div class="about__client-item">
                                    <?php if ( ! empty( $img_url ) ) : ?>
                                        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="about__client-img">
                                    <?php endif; ?>
                                    <?php if ( $title ) : ?>
                                        <p class="about__client-title"><?php echo esc_html( $title ); ?></p>
                                    <?php endif; ?>
                                </div>
                        <?php 
                                endwhile;
                            endif;
                        ?>
                    </div>
                </div>
                <div class="about__block about__block-team" id="team">
                    <article class="about__licence__article">
                        <h2 class="about__licence-title">
                            <?php the_field('team_title', 'option'); ?>
                        </h2>
                        <p class="about__licence-subtitle">
                            <?php the_field('team_subtitle', 'option'); ?>
                        </p>
                    </article>
                    <div class="about__team-list">
                        <?php 
                            $repeater_source = have_rows( 'team_repeater', 'option' ) ? 'option' : null;
                            if ( ! $repeater_source ) {
                                $repeater_source = have_rows( 'team_repeater' ) ? get_the_ID() : null;
                            }
                            
                            if ( $repeater_source && have_rows( 'team_repeater', $repeater_source ) ) :
                                while ( have_rows( 'team_repeater', $repeater_source ) ) : the_row();
                                    $photo = get_sub_field( 'team_repeater_photo' );
                                    $rank = get_sub_field( 'team_repeater_rank' );
                                    $title = get_sub_field( 'team_repeater_title' );
                                    
                                    // Получаем URL изображения
                                    $img_url = '';
                                    if ( $photo ) {
                                        if ( is_array( $photo ) ) {
                                            $img_url = $photo['url'] ?? '';
                                        } elseif ( is_numeric( $photo ) ) {
                                            $img_url = wp_get_attachment_image_url( $photo, 'full' );
                                        } else {
                                            $img_url = $photo;
                                        }
                                    }
                        ?>
                                <div class="about__team-item">
                                    <?php if ( $img_url ) : ?>
                                        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="about__team-img">
                                    <?php endif; ?>
                                    <article class="about__team-article">
                                        <?php if ( $rank ) : ?>
                                            <p class="about__team-subtitle">
                                                <?php echo esc_html( $rank ); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $title ) : ?>
                                            <h3 class="about__team-title">
                                                <?php echo esc_html( $title ); ?>
                                            </h3>
                                        <?php endif; ?>
                                    </article>
                                </div>
                        <?php 
                                endwhile;
                            endif;
                        ?>
                    </div>
                </div>
                <div class="about__block about__block-work" id="work">
                    <article class="about__licence__article">
                        <h2 class="about__licence-title">
                            <?php the_field('work_title', 'option'); ?>
                        </h2>
                        <p class="about__licence-subtitle">
                            <?php the_field('work_subtitle', 'option'); ?>
                        </p>
                    </article>
                    <div class="about__work-vacancy">
                        <div class="faq__accordion">
                            <div class="faq__accordion-list">
                                <?php 
                                    $repeater_source = have_rows( 'work_repeater', 'option' ) ? 'option' : null;
                                    if ( ! $repeater_source ) {
                                        $repeater_source = have_rows( 'work_repeater' ) ? get_the_ID() : null;
                                    }
                                    
                                    if ( $repeater_source && have_rows( 'work_repeater', $repeater_source ) ) :
                                        while ( have_rows( 'work_repeater', $repeater_source ) ) : the_row();
                                            $title = get_sub_field( 'work_repeater_title' );
                                            $subtitle = get_sub_field( 'work_repeater_subtitle' );
                                            $price = get_sub_field( 'work_repeater_price' );
                                            $description = get_sub_field( 'work_repeater_description' );
                                ?>
                                        <div class="faq__accordion-item">
                                            <div class="faq__accordion-header">
                                                <article class="faq__acoordion-article">
                                                    <?php if ( $title ) : ?>
                                                        <h4 class="faq__accordion-title">
                                                            <?php echo esc_html( $title ); ?>
                                                        </h4>
                                                    <?php endif; ?>
                                                    <?php if ( $subtitle ) : ?>
                                                        <p class="faq__accordion-text">
                                                            <?php echo esc_html( $subtitle ); ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </article>
                                                <?php if ( $price ) : ?>
                                                    <strong class="faq__accordion-price">
                                                        <?php echo esc_html( $price ); ?>
                                                    </strong>
                                                <?php endif; ?>
                                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/icons/chevron.svg" alt="шеврон" class="faq__accordion-arrow">
                                            </div>
                                            <div class="faq__accordion-content">
                                                <?php if ( $description ) : ?>
                                                    <div class="faq__accordion-text">
                                                        <?php echo wp_kses_post( $description ); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                <?php 
                                        endwhile;
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about__block about__block-detail" id="detail">
                    <article class="about__licence__article">
                        <h2 class="about__licence-title">
                            <?php the_field('detail_title', 'option'); ?>
                        </h2>
                        <p class="about__licence-subtitle">
                            <?php the_field('detail_subtitle', 'option'); ?>
                        </p>
                    </article>
                    <div class="about__detail-list">
                        <?php if( have_rows('detail_repeater', 'option') ): ?>
                            <?php while( have_rows('detail_repeater', 'option') ): the_row(); ?>
                                <div class="about__detail-item">
                                    <h4 class="about__detail-title"><?php the_sub_field('detail_name', 'option'); ?></h4>
                                    <p class="about__detail-subtitle"><?php the_sub_field('detail_result', 'option'); ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Информация не добавлена</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
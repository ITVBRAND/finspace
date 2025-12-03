<?php
/**
 * The header for our theme
 *
 * @package vbrand_custom
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="header">
		<div class="container">
			<div class="header__top">
				<div class="header__fixed-wrap">
					<a href="/" class="header__link logo">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/picture/logo.svg" alt="логотип" class="header__logo">
					</a>
				</div>
				<div class="search-container">
					<div class="search-input-wrapper">
						<svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="#868686" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" id="search-input" class="search-input" placeholder="Найти" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
						</form>
					</div>
				</div>
				<div class="header__contact-info">
					<p class="header__contact header__link">
						<?php if ( function_exists('the_field') ) the_field("header_tel_name", "option"); ?>
					</p>
					<div class="header__contact-modal">
						<div class="header__contact-list top">
							<?php if ( function_exists('have_rows') && have_rows('option_tel_repeater', 'option') ): ?>
								<?php while ( have_rows('option_tel_repeater', 'option') ): the_row(); ?>
									<?php 
										$tel_name = get_sub_field('option_tel_name');
										$tel_link = get_sub_field('option_tel_link');
									?>
									<div class="header__contact-item">
										<p class="header__contact-item title">
											<?php echo esc_html( $tel_name ); ?>
										</p>
										<a href="tel:<?php echo esc_attr( preg_replace('/[^+0-9]/', '', $tel_link) ); ?>" class="header__contact-item link">
											<?php echo esc_html( $tel_link ); ?>
										</a>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if ( function_exists('get_field') && get_field("option_default_mail", "option") ): ?>
								<div class="header__contact-item">
									<p class="header__contact-item title">
										Email:
									</p>
									<a href="mailto:<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>" class="header__contact-item link">
										<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
						<div class="header__contact-list bottom">
							<?php if( have_rows('option_addres_repeater', 'option') ): ?>
								<?php while( have_rows('option_addres_repeater', 'option') ): the_row(); ?>
									<div class="header__contact-item">
										<p class="header__contact-item title">
											<?php the_sub_field('option_addres_title', 'option'); ?>
										</p>
										<a href="<?php the_sub_field('option_addres_link', 'option'); ?>" class="header__contact-item link">
											<?php the_sub_field('option_addres_text', 'option'); ?>
										</a>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if ( function_exists('get_field') && get_field("option_timer", "option") ): ?>
								<div class="header__contact-item">
									<p class="header__contact-item title">
										Режим работы:
									</p>
									<p class="header__contact-item link">
										<?php if ( function_exists('the_field') ) the_field("option_timer", "option"); ?>
									</p>
								</div>
							<?php endif; ?>
							<?php if ( function_exists('get_field') && get_field("option_social_repeater", "option") ): ?>
								<div class="header__contact-item">
									<p class="header__contact-item title">
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
													<a href="<?php echo esc_url( $social_link ); ?>" class="header__contact-social item" target="_blank" rel="noopener noreferrer">
														<img src="<?php echo esc_url( $icon_url ); ?>" class="header__contact-social img" alt="social icon">
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

				<button class="btn-default header__btn message js-modal-contact">Оставить заявку</button>
				<button class="header__burger-btn">
					<span class="burger-icon">
						<span class="burger-line"></span>
						<span class="burger-line"></span>
						<span class="burger-line"></span>
					</span>
				</button>
			</div>
			<nav class="header__nav">
				<?php
					if ( function_exists('have_rows') && ( have_rows('nav_link_add', 'option') || have_rows('nav_link_add') ) ) {
						// сначала пробуем опции сайта
						if ( have_rows('nav_link_add', 'option') ) {
							while ( have_rows('nav_link_add', 'option') ) { the_row();
								$link_name = trim( (string) get_sub_field('nav_link_name') );
								$link_url  = (string) get_sub_field('nav_link');
								if ( $link_name && $link_url ) {
									echo '<a href="' . esc_url( $link_url ) . '" class="header__link">' . esc_html( $link_name ) . '</a>';
								}
							}
						} else {
							while ( have_rows('nav_link_add') ) { the_row();
								$link_name = trim( (string) get_sub_field('nav_link_name') );
								$link_url  = (string) get_sub_field('nav_link');
								if ( $link_name && $link_url ) {
									echo '<a href="' . esc_url( $link_url ) . '" class="header__link">' . esc_html( $link_name ) . '</a>';
								}
							}
						}
					}
				?>
			</nav>
		</div>
	</header>
	<!-- Мобильное меню -->
	<div class="mobile-menu" id="mobileMenu">
		<div class="mobile-menu__overlay"></div>
		<div class="mobile-menu__content">
			<div class="mobile-menu__header">
				<a href="/" class="mobile-menu__logo">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/picture/logo.svg" alt="логотип">
				</a>
				<button class="mobile-menu__close" id="mobileMenuClose">
					<span class="close-icon">
						<span class="close-line"></span>
						<span class="close-line"></span>
					</span>
				</button>
			</div>
			<nav class="mobile-menu__nav">
				<?php
					if ( function_exists('have_rows') && ( have_rows('nav_link_add', 'option') || have_rows('nav_link_add') ) ) {
						// сначала пробуем опции сайта
						if ( have_rows('nav_link_add', 'option') ) {
							while ( have_rows('nav_link_add', 'option') ) { the_row();
								$link_name = trim( (string) get_sub_field('nav_link_name') );
								$link_url  = (string) get_sub_field('nav_link');
								if ( $link_name && $link_url ) {
									echo '<a href="' . esc_url( $link_url ) . '" class="mobile-menu__link">' . esc_html( $link_name ) . '</a>';
								}
							}
						} else {
							while ( have_rows('nav_link_add') ) { the_row();
								$link_name = trim( (string) get_sub_field('nav_link_name') );
								$link_url  = (string) get_sub_field('nav_link');
								if ( $link_name && $link_url ) {
									echo '<a href="' . esc_url( $link_url ) . '" class="mobile-menu__link">' . esc_html( $link_name ) . '</a>';
								}
							}
						}
					}
				?>
			</nav>
			<div class="mobile-menu__actions">
				<button class="btn-default js-modal-contact">Оставить заявку</button>
			</div>
			<div class="mobile-menu__contact">
				<?php if ( function_exists('have_rows') && have_rows('option_tel_repeater', 'option') ): ?>
					<?php while ( have_rows('option_tel_repeater', 'option') ): the_row(); ?>
						<?php 
							$tel_name = get_sub_field('option_tel_name');
							$tel_link = get_sub_field('option_tel_link');
						?>
						<div class="header__contact-item">
							<p class="header__contact-item title">
								<?php echo esc_html( $tel_name ); ?>
							</p>
							<a href="tel:<?php echo esc_attr( preg_replace('/[^+0-9]/', '', $tel_link) ); ?>" class="header__contact-item link">
								<?php echo esc_html( $tel_link ); ?>
							</a>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
				<?php if ( function_exists('get_field') && get_field("option_default_mail", "option") ): ?>
					<div class="header__contact-item">
						<p class="header__contact-item title">
							Email:
						</p>
						<a href="mailto:<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>" class="header__contact-item link">
							<?php if ( function_exists('the_field') ) the_field("option_default_mail", "option"); ?>
						</a>
					</div>
				<?php endif; ?>
				<?php if( have_rows('option_addres_repeater', 'option') ): ?>
                    <?php while( have_rows('option_addres_repeater', 'option') ): the_row(); ?>
						<div class="header__contact-item">
							<p class="header__contact-item title">
								<?php the_sub_field('option_addres_title', 'option'); ?>
							</p>
							<a href="<?php the_sub_field('option_addres_link', 'option'); ?>" class="header__contact-item link">
								<?php the_sub_field('option_addres_text', 'option'); ?>
							</a>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
				<?php if ( function_exists('get_field') && get_field("option_timer", "option") ): ?>
					<div class="header__contact-item">
						<p class="header__contact-item title">
							Режим работы:
						</p>
						<p class="header__contact-item link">
							<?php if ( function_exists('the_field') ) the_field("option_timer", "option"); ?>
						</p>
					</div>
				<?php endif; ?>
				<?php if ( function_exists('get_field') && get_field("option_social_repeater", "option") ): ?>
					<div class="header__contact-item">
						<p class="header__contact-item title">
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
										<a href="<?php echo esc_url( $social_link ); ?>" class="header__contact-social item" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo esc_url( $icon_url ); ?>" class="header__contact-social img" alt="social icon">
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
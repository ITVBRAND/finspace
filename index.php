<?php
	get_header();
?>

<main class="page">
	<div class="hero">
		<section class="container">
			<div class="hero__wrap" id="indicatorsSection">
				<article class="hero__article">
					<div class="hero__article-header">
						<h1 class="hero__title">
							Отдайте всё самое <span class="purple">сложное, долгое и непонятное</span> нам
						</h1>
						<p class="hero__subtitle">
							Берём на себя рутину учёта, налоги, отчётность и юридические риски, чтобы вы сосредоточились на развитии бизнеса, а не на бюрократии.
						</p>
					</div>
					<div class="hero__article-btns">
						<button class="btn hero__btn btn-default js-modal-contact">Оставить заявку</button>
					</div>
				</article>
				<ul class="hero__list">
					<li class="hero__item">
						<p class="hero__item-title">
							<span class="counter" data-target="460">0</span>
						</p>
						<p class="hero__item-subtitle">
							компаний из <span class="counter" data-target="120">0</span> сфер обслужили за 2025 год
						</p>
					</li>
					<li class="hero__item">
						<p class="hero__item-title">
						<span class="counter" data-target="100" data-suffix="%">0%</span>
						</p>
						<p class="hero__item-subtitle">
							выигранных споров<br>с налоговой 
						</p>
					</li>
					<li class="hero__item">
						<p class="hero__item-title">
							<span class="counter" data-target="600" data-prefix="+">+0</span>
						</p>
						<p class="hero__item-subtitle">
							клиентов на ведении<br>по всей стране
						</p>
					</li>
				</ul>
				<picture class="hero__preview-wrap">
					<source media="(max-width: 768px)" srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/picture/hero_mob.svg' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/picture/hero_img.webp' ); ?>" alt="финспейс" class="hero__preview">
				</picture>
			</div>
		</section>
	</div>
	<div class="sticky">
		<section class="section services">
			<div class="container">
				<div class="services__block">
					<article class="section__article">
						<h2 class="section__title">
							Ваш путь к финансовой эффективности начинается <span class="purple">здесь</span>
						</h2>
					</article>
					<div class="services__wrapper">
						<div class="services__filter">
							<div class="services__filter-item">
								<label class="services__filter-label" for="servicesCategory">Выберите категорию:</label>
								<select class="services__filter-select" name="servicesCategory" id="servicesCategory">
									<option value="">Все категории</option>
									<?php
									$categories = get_terms( array(
										'taxonomy'   => 'service_category',
										'hide_empty' => false,
									) );
									if ( $categories && ! is_wp_error( $categories ) ) :
										foreach ( $categories as $category ) :
									?>
										<option value="<?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name ); ?></option>
									<?php
										endforeach;
									endif;
									?>
								</select>
							</div>
							<div class="services__filter-item">
								<label class="services__filter-label" for="servicesTag">Для кого:</label>
								<select class="services__filter-select" name="servicesTag" id="servicesTag">
									<option value="">Все</option>
									<?php
									$tags = get_terms( array(
										'taxonomy'   => 'service_tag',
										'hide_empty' => false,
									) );
									if ( $tags && ! is_wp_error( $tags ) ) :
										foreach ( $tags as $tag ) :
									?>
										<option value="<?php echo esc_attr( $tag->slug ); ?>"><?php echo esc_html( $tag->name ); ?></option>
									<?php
										endforeach;
									endif;
									?>
								</select>
							</div>
							<div class="services__filter-item">
								<button class="btn-default btn-services">Подобрать услугу</button>
							</div>
						</div>
						<div class="swiper services-swiper">
							<div class="swiper-wrapper">
								<?php
								$services_args = array(
									'post_type'      => 'services',
									'posts_per_page' => -1,
									'orderby'        => 'date',
									'order'          => 'DESC',
								);
								$services_query = new WP_Query( $services_args );

								if ( $services_query->have_posts() ) :
									while ( $services_query->have_posts() ) :
										$services_query->the_post();
										$service_categories = get_the_terms( get_the_ID(), 'service_category' );
										$service_tags = get_the_terms( get_the_ID(), 'service_tag' );
										
										$category_slug = ( $service_categories && ! is_wp_error( $service_categories ) ) ? $service_categories[0]->slug : '';
										$tag_slugs = array();
										if ( $service_tags && ! is_wp_error( $service_tags ) ) {
											foreach ( $service_tags as $tag ) {
												$tag_slugs[] = $tag->slug;
											}
										}
								?>
								<a href="<?php the_permalink(); ?>" class="swiper-slide services-slide" data-category="<?php echo esc_attr( $category_slug ); ?>" data-tags="<?php echo esc_attr( implode( ',', $tag_slugs ) ); ?>">
									<div class="services-slide__header">
										<?php if ( $service_categories && ! is_wp_error( $service_categories ) ) : ?>
										<div class="tab">
											<p><?php echo esc_html( $service_categories[0]->name ); ?></p>
										</div>
										<?php endif; ?>
										<div class="link-arrow"></div>
									</div>
									<h3 class="services-slide__title"><?php the_title(); ?></h3>
								</a>
								<?php
									endwhile;
									wp_reset_postdata();
								endif;
								?>
							</div>
							<p class="services-empty" style="display: none;">Нет услуг с таким фильтром</p>
						</div>
						<button class="services-swiper__prev"></button>
						<button class="services-swiper__next"></button>
					</div>
				</div>
			</div>
		</section>
		<section class="section tags">
			<article class="section__article tags__article">
				<h2 class="section__title section__title-cntr">
					Финансовое сопровождение<br>для <span class="purple">любых</span> задач и отраслей
				</h2>
			</article>
			<div class="tags__wrapper">
				<div class="tags__list">
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
				</div>
				<div class="tags__list">
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
					<p class="tags__item">Общественное питание и кулинария</p>
					<p class="tags__item">Услуги IT</p>
					<p class="tags__item">Бьюти индустрия</p>
					<p class="tags__item">Производство</p>
					<p class="tags__item">ВЭД и валютные операции</p>
					<p class="tags__item">Стоматологические услуги</p>
				</div>
			</div>
		</section>
		<section class="section about">
			<div class="container">
				<div class="about__wrapper">
					<article class="section__article section__article-cntr">
						<h2 class="section__title">
							Кто <span class="purple">мы</span>
						</h2>
						<p class="section__subtitle">
							Финспэйс — партнер, который надежно выполняет взятые на себя обязательства. Избавляем клиента от стрессовых ситуаций при взаимодействиис ФНС и несём материальную ответственность за свою работуи её результат.
						</p>
					</article>
					<picture class="about__picture">
						<img class="about__img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/picture/about_banner_desktop.webp' ); ?>" />
					</picture>
					<a href="/about" class="btn-link">Подробнее о компании</a>
				</div>
			</div>
		</section>
		<section class="section review">
			<div class="container">
				<div class="review__block">
					<article class="section__article">
						<h2 class="section__title">
							Отзывы довольных клиентов
						</h2>
					</article>
					<div class="review__wrapper">
						<div class="swiper review-swiper">
							<div class="swiper-wrapper">
								<?php 
								// Проверяем наличие повторителя отзывов
								if ( function_exists('have_rows') && have_rows('repeater_reviews', 'option') ) :
									while ( have_rows('repeater_reviews', 'option') ) : the_row();
										$review_photo = get_sub_field('review_photo');
										$review_ranking = get_sub_field('review_ranking');
										$review_name = get_sub_field('review_name');
										$review_comment = get_sub_field('review_comment');
										
										// Получаем URL изображения
										$photo_url = '';
										$photo_alt = '';
										
										if ( $review_photo ) {
											if ( is_array($review_photo) && !empty($review_photo['url']) ) {
												$photo_url = $review_photo['url'];
												$photo_alt = !empty($review_photo['alt']) ? $review_photo['alt'] : $review_name;
											} elseif ( is_numeric($review_photo) ) {
												$photo_url = wp_get_attachment_image_url( intval($review_photo), 'full' );
												$photo_alt = get_post_meta( intval($review_photo), '_wp_attachment_image_alt', true );
												if ( !$photo_alt ) {
													$photo_alt = $review_name;
												}
											} elseif ( is_string($review_photo) ) {
												$photo_url = $review_photo;
												$photo_alt = $review_name;
											}
										}
										
										// Выводим слайд только если есть хотя бы имя или комментарий
										if ( $review_name || $review_comment ) :
											?>
											<div class="swiper-slide review-slide">
												<div class="review-slide__header">
													<div class="tab">
														<p>
															Отзыв
														</p>
													</div>
												</div>
												<?php if ( $photo_url ) : ?>
													<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $photo_alt ); ?>" class="review-slide__img">
												<?php endif; ?>
												<div class="review-slide__body">
													<article class="review-slide__article">
														<?php if ( $review_ranking ) : ?>
															<p class="review-slide__ranking">
																<?php echo esc_html( $review_ranking ); ?>
															</p>
														<?php endif; ?>
														<?php if ( $review_name ) : ?>
															<h3 class="review-slide__name">
																<?php echo esc_html( $review_name ); ?>
															</h3>
														<?php endif; ?>
														<?php if ( $review_comment ) : ?>
															<p class="review-slide__comment">
																<?php echo wp_kses_post( $review_comment ); ?><a href="https://yandex.ru/maps/org/finspeys/224516834059/reviews/" target="blank_">, читать далее...</a>
															</p>
														<?php endif; ?>
													</article>
												</div>
											</div>
											<?php
										endif;
									endwhile;
								endif;
								?>
							</div>
						</div>
						<button class="review-swiper__prev"></button>
						<button class="review-swiper__next"></button>
					</div>
				</div>
			</div>
		</section>
		<section class="section blog">
			<div class="container">
				<div class="blog__wrapper">
					<article class="section__article section__article-blog">
						<h2 class="section__title">
							О бухгалтерий простым языком
						</h2>
						<div class="blog__category">
							<button class="blog__category-item active" data-category="all">
								Все
							</button>
							<?php
							$blog_categories = get_terms( array(
								'taxonomy'   => 'blog_category',
								'hide_empty' => true,
							) );
							if ( $blog_categories && ! is_wp_error( $blog_categories ) ) :
								foreach ( $blog_categories as $cat ) :
							?>
								<button class="blog__category-item" data-category="<?php echo esc_attr( $cat->term_id ); ?>">
									<?php echo esc_html( $cat->name ); ?>
								</button>
							<?php
								endforeach;
							endif;
							?>
						</div>
					</article>
					<?php
					$blog_args = array(
						'post_type'      => 'blog',
						'posts_per_page' => 8,
						'orderby'        => 'date',
						'order'          => 'DESC',
					);
					$blog_query = new WP_Query( $blog_args );
					if ( $blog_query->have_posts() ) :
					?>
					<div class="swiper blog-swiper">
						<div class="swiper-wrapper">
							<?php
							while ( $blog_query->have_posts() ) :
								$blog_query->the_post();
								$categories = get_the_terms( get_the_ID(), 'blog_category' );
								$title = get_the_title();
								if ( mb_strlen( $title ) > 52 ) {
									$title = mb_substr( $title, 0, 52 ) . '...';
								}
							?>
							<a href="<?php the_permalink(); ?>" class="swiper-slide blog-slide" data-category-ids="<?php 
								if ( $categories && ! is_wp_error( $categories ) ) {
									$cat_ids = array();
									foreach ( $categories as $cat ) {
										$cat_ids[] = $cat->term_id;
									}
									echo esc_attr( implode( ',', $cat_ids ) );
								}
							?>">
								<div class="blog-slide__wrapper">
									<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
										<div class="blog-slide__tabs">
											<div class="blog-slide__tab"><?php echo esc_html( $categories[0]->name ); ?></div>
										</div>
									<?php endif; ?>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium', array( 'class' => 'blog-slide__images', 'alt' => esc_attr( get_the_title() ) ) ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/picture/example_review.webp' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="blog-slide__images">
									<?php endif; ?>
								</div>
								<article class="blog-slide__article">
									<p class="blog-slide__date">
										<?php echo esc_html( get_the_date() ); ?>
									</p>
									<h3 class="blog-slide__title">
										<?php echo esc_html( $title ); ?>
									</h3>
								</article>
							</a>
							<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
					<?php endif; ?>
					<button class="blog-swiper__prev"></button>
					<button class="blog-swiper__next"></button>
				</div>
			</div>
		</section>
	</div>
</main>

<?php
	get_footer();

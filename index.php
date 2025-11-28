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
						<button class="btn hero__btn btn-link">Рассчитать стоимость</button>
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
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
				</div>
				<div class="tags__list">
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
					<a href="#" class="tags__item">Общественное питание и кулинария</a>
					<a href="#" class="tags__item">Услуги IT</a>
					<a href="#" class="tags__item">Бьюти индустрия</a>
					<a href="#" class="tags__item">Производство</a>
					<a href="#" class="tags__item">ВЭД и валютные операции</a>
					<a href="#" class="tags__item">Стоматологические услуги</a>
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
				<div class="review__wrapper">
					<article class="section__article">
						<h2 class="section__title">
							Отзывы довольных клиентов
						</h2>
					</article>
				</div>
				<!--swiper-с-отзывами-->
			</div>
		</section>
		<section class="section blog">
			<div class="container">
				<div class="blog__wrapper">
					<article class="section__article">
						<h2 class="section__title">
							О бухгалтерий простым языком
						</h2>
					</article>
				</div>
				<!--табы с категориями-->
				<!--swiper-с-блогом-->
			</div>
		</section>
	</div>
</main>

<?php
	get_footer();

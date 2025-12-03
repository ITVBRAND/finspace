document.addEventListener('DOMContentLoaded', function() {
    const swiperElement = document.querySelector(".blog-swiper");
    if (!swiperElement) return;
    
    // Получаем все слайды
    const slides = swiperElement.querySelectorAll('.blog-slide');
    const slidesCount = slides.length;
    
    // Получаем кнопки навигации
    const prevButton = document.querySelector(".blog-swiper__prev");
    const nextButton = document.querySelector(".blog-swiper__next");
    
    // Получаем кнопки категорий
    const categoryButtons = document.querySelectorAll('.blog__category-item');
    
    // Инициализация Swiper
    var swiper = new Swiper(".blog-swiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: false,
        watchOverflow: true,
        navigation: {
            nextEl: ".blog-swiper__next",
            prevEl: ".blog-swiper__prev",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10,
                centeredSlides: true,
                loop: false,
            },

            768: {
                slidesPerView: 2,
                spaceBetween: 20,
                centeredSlides: false,
                loop: false,
            },

            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
                centeredSlides: false,
                loop: false,
            },
        },
    });
    
    // Функция для обновления видимости слайдов
    function updateSlidesVisibility(selectedCategory) {
        let visibleCount = 0;
        
        slides.forEach(function(slide) {
            const categoryIds = slide.getAttribute('data-category-ids');
            
            if (selectedCategory === 'all' || !categoryIds) {
                slide.style.display = '';
                visibleCount++;
            } else {
                const slideCategories = categoryIds.split(',');
                if (slideCategories.includes(selectedCategory)) {
                    slide.style.display = '';
                    visibleCount++;
                } else {
                    slide.style.display = 'none';
                }
            }
        });
        
        // Обновляем Swiper после изменения видимости
        swiper.update();
        
        // Скрываем/показываем кнопки навигации
        if (visibleCount < 4) {
            if (prevButton) prevButton.style.display = 'none';
            if (nextButton) nextButton.style.display = 'none';
        } else {
            if (prevButton) prevButton.style.display = '';
            if (nextButton) nextButton.style.display = '';
        }
        
        // Переходим на первый слайд
        swiper.slideTo(0);
    }
    
    // Обработчики кликов на кнопки категорий
    categoryButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Убираем активный класс со всех кнопок
            categoryButtons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            
            // Добавляем активный класс к нажатой кнопке
            this.classList.add('active');
            
            // Получаем выбранную категорию
            const selectedCategory = this.getAttribute('data-category');
            
            // Обновляем видимость слайдов
            updateSlidesVisibility(selectedCategory);
        });
    });
    
    // Инициализация при загрузке
    const activeButton = document.querySelector('.blog__category-item.active');
    if (activeButton) {
        const initialCategory = activeButton.getAttribute('data-category');
        updateSlidesVisibility(initialCategory);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const swiperElement = document.querySelector(".review-swiper");
    if (!swiperElement) return;
    
    // Подсчитываем количество слайдов
    const slides = swiperElement.querySelectorAll('.swiper-slide');
    const slidesCount = slides.length;
    
    // Получаем кнопки навигации
    const prevButton = document.querySelector(".review-swiper__prev");
    const nextButton = document.querySelector(".review-swiper__next");
    
    // Если слайдов меньше 4, скрываем кнопки
    if (slidesCount < 4) {
        if (prevButton) prevButton.style.display = 'none';
        if (nextButton) nextButton.style.display = 'none';
    }
    
    var swiper = new Swiper(".review-swiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: slidesCount >= 4, // Включаем loop только если слайдов >= 4
        watchOverflow: true,
        navigation: {
            nextEl: ".review-swiper__next",
            prevEl: ".review-swiper__prev",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10,
                centeredSlides: true,
                loop: false, // Отключаем loop на мобильных для правильного отображения
            },

            768: {
                slidesPerView: 2,
                spaceBetween: 20,
                centeredSlides: false,
                loop: slidesCount >= 4,
            },

            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
                centeredSlides: false,
                loop: slidesCount >= 4,
            },
        },
    });
});
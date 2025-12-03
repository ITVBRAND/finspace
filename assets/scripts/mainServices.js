var swiper = new Swiper(".services-swiper", {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    watchOverflow: true,
    navigation: {
        nextEl: ".services-swiper__next",
        prevEl: ".services-swiper__prev",
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
            loop: true,
        },

        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
            centeredSlides: false,
            loop: true,
        },
    },
});

// Фильтрация услуг
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('servicesCategory');
    const tagSelect = document.getElementById('servicesTag');
    const filterBtn = document.querySelector('.btn-services');
    const slides = document.querySelectorAll('.services-slide');

    const emptyMessage = document.querySelector('.services-empty');

    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            const selectedCategory = categorySelect ? categorySelect.value : '';
            const selectedTag = tagSelect ? tagSelect.value : '';
            let visibleCount = 0;

            slides.forEach(function(slide) {
                const slideCategory = slide.dataset.category || '';
                const slideTags = slide.dataset.tags ? slide.dataset.tags.split(',') : [];

                const categoryMatch = !selectedCategory || slideCategory === selectedCategory;
                const tagMatch = !selectedTag || slideTags.includes(selectedTag);

                if (categoryMatch && tagMatch) {
                    slide.style.display = '';
                    visibleCount++;
                } else {
                    slide.style.display = 'none';
                }
            });

            if (emptyMessage) {
                emptyMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            swiper.update();
        });
    }
});

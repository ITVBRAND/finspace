document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.about__nav-link');
    const sections = document.querySelectorAll('.about__block[id]');
    
    if (navLinks.length === 0 || sections.length === 0) {
        return;
    }

    // Функция для определения активной секции
    function updateActiveNav() {
        let currentSection = '';
        const scrollPosition = window.scrollY + 150; // Offset для sticky навигации

        // Проходим по всем секциям в обратном порядке
        for (let i = sections.length - 1; i >= 0; i--) {
            const section = sections[i];
            const sectionTop = section.offsetTop;
            
            if (scrollPosition >= sectionTop) {
                currentSection = section.getAttribute('id');
                break;
            }
        }

        // Если мы в самом верху страницы, активируем первую секцию
        if (scrollPosition < sections[0].offsetTop) {
            currentSection = sections[0].getAttribute('id');
        }

        // Обновляем активные классы
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === '#' + currentSection) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    // Обработчик прокрутки с throttling для производительности
    let ticking = false;
    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                updateActiveNav();
                ticking = false;
            });
            ticking = true;
        }
    }

    // Инициализация при загрузке страницы
    updateActiveNav();

    // Обработчик прокрутки
    window.addEventListener('scroll', onScroll, { passive: true });

    // Плавная прокрутка при клике на навигационные ссылки
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                const targetId = href.substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    e.preventDefault();
                    const offsetTop = targetSection.offsetTop - 80; // Offset для sticky header
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});


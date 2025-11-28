document.addEventListener('DOMContentLoaded', function() {
    // Анимация счетчиков индикаторов
    function animateCounter(counterElement) {
        const target = parseInt(counterElement.getAttribute('data-target'));
        const prefix = counterElement.getAttribute('data-prefix') || '';
        const suffix = counterElement.getAttribute('data-suffix') || '';
        const duration = 2000; // Длительность анимации в миллисекундах
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                const value = Math.floor(current);
                counterElement.textContent = prefix + value + suffix;
                requestAnimationFrame(updateCounter);
            } else {
                counterElement.textContent = prefix + target + suffix;
            }
        };

        updateCounter();
    }

    // Отслеживание появления секции с индикаторами
    const indicatorsSection = document.getElementById('indicatorsSection');
    if (indicatorsSection) {
        const counters = indicatorsSection.querySelectorAll('.counter');
        let hasAnimated = false;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasAnimated) {
                    hasAnimated = true;
                    counters.forEach((counter, index) => {
                        // Небольшая задержка между каждым счетчиком для эффекта последовательности
                        setTimeout(() => {
                            animateCounter(counter);
                        }, index * 200);
                    });
                }
            });
        }, {
            threshold: 0.3 // Анимация запустится, когда 30% секции будет видно
        });

        observer.observe(indicatorsSection);
    }
});


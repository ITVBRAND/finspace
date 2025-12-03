document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.faq__accordion-item');

    accordionItems.forEach(item => {
        const header = item.querySelector('.faq__accordion-header');
        const content = item.querySelector('.faq__accordion-content');
        const arrow = item.querySelector('.faq__accordion-arrow');

        if (!header || !content || !arrow) return;

        // Инициализация: закрываем все элементы по умолчанию
        item.classList.add('closed');
        content.style.maxHeight = '0';
        content.style.overflow = 'hidden';
        content.style.transition = 'max-height 0.3s ease, padding 0.3s ease';

        header.addEventListener('click', function() {
            const isOpen = item.classList.contains('active');

            // Закрываем все другие элементы (опционально, для аккордеона типа "только один открыт")
            accordionItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    closeAccordionItem(otherItem);
                }
            });

            // Переключаем текущий элемент
            if (isOpen) {
                closeAccordionItem(item);
            } else {
                openAccordionItem(item);
            }
        });
    });

    function openAccordionItem(item) {
        const content = item.querySelector('.faq__accordion-content');
        const arrow = item.querySelector('.faq__accordion-arrow');

        item.classList.remove('closed');
        item.classList.add('active');

        // Получаем реальную высоту контента
        const height = content.scrollHeight;
        
        // Устанавливаем максимальную высоту для плавной анимации
        content.style.maxHeight = height + 'px';
        
        // Поворачиваем стрелку
        if (arrow) {
            arrow.style.transform = 'rotate(90deg)';
        }
    }

    function closeAccordionItem(item) {
        const content = item.querySelector('.faq__accordion-content');
        const arrow = item.querySelector('.faq__accordion-arrow');

        item.classList.remove('active');
        item.classList.add('closed');
        
        content.style.maxHeight = '0';
        
        // Возвращаем стрелку в исходное положение
        if (arrow) {
            arrow.style.transform = 'rotate(0deg)';
        }
    }
});
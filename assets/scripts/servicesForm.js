document.addEventListener('DOMContentLoaded', function() {
    // ===== РФ маска телефона: +7 (XXX) XXX XX-XX =====
    function formatRuPhone(raw) {
        // Оставляем только цифры
        let digits = (raw || '').replace(/\D+/g, '');
        // Если начинается с 8 или 7, убираем ведущую
        if (digits.startsWith('8')) digits = digits.slice(1);
        else if (digits.startsWith('7')) digits = digits.slice(1);
        // Если пользователь начал с 9 (мобильные), оставляем как есть
        // Берем максимум 10 цифр после кода страны
        digits = digits.slice(0, 10);
        let res = '+7';
        if (digits.length > 0) {
            res += ' (' + digits.substring(0, Math.min(3, digits.length));
            if (digits.length >= 3) res += ')';
        }
        if (digits.length > 3) {
            res += ' ' + digits.substring(3, Math.min(6, digits.length));
        }
        if (digits.length > 6) {
            res += ' ' + digits.substring(6, Math.min(8, digits.length));
        }
        if (digits.length > 8) {
            res += '-' + digits.substring(8, Math.min(10, digits.length));
        }
        return res;
    }

    function onPhoneInput(e) {
        const input = e.target;
        const start = input.selectionStart;
        const before = input.value;
        input.value = formatRuPhone(input.value);
        // Простейшая коррекция каретки
        const diff = input.value.length - before.length;
        try { input.setSelectionRange(Math.max(0, start + diff), Math.max(0, start + diff)); } catch(_) {}
    }

    function onPhoneBlur(e) {
        const input = e.target;
        // Если введено мало цифр, очищаем
        const digits = input.value.replace(/\D+/g, '');
        if (digits.length < 11) { // +7 и ещё 10 цифр = 11 общих
            input.value = '';
        }
    }

    function bindPhoneMask(root) {
        (root || document).querySelectorAll('input[type="tel"]').forEach(inp => {
            inp.addEventListener('input', onPhoneInput);
            inp.addEventListener('blur', onPhoneBlur);
            inp.addEventListener('paste', function(e){
                requestAnimationFrame(() => onPhoneInput({ target: inp }));
            });
        });
    }

    // Получаем название услуги
    function getServiceName() {
        // Пытаемся получить из data-атрибута формы
        const form = document.querySelector('.single-form__form');
        if (form && form.dataset.serviceName) {
            return form.dataset.serviceName;
        }
        
        // Пытаемся получить из заголовка страницы
        const h1 = document.querySelector('h1');
        if (h1) {
            return h1.textContent.trim();
        }
        
        // Пытаемся получить из заголовка формы
        const formTitle = document.querySelector('.single-form__title');
        if (formTitle) {
            // Убираем "Оставить заявку на услугу" и оставляем только название
            const text = formTitle.textContent.trim();
            return text.replace(/^Оставить заявку на услугу\s*/i, '') || 'Услуга';
        }
        
        return 'Услуга';
    }

    // Инициализация формы
    function initServiceForm() {
        const form = document.querySelector('.single-form__form');
        if (!form) return;
        
        // Проверяем, не добавлен ли уже обработчик
        if (form.dataset.initialized === 'true') return;
        form.dataset.initialized = 'true';
        
        // Применяем маску телефона
        bindPhoneMask(form);
        
        // Создаем элемент для статуса
        let status = form.querySelector('.single-form__status');
        if (!status) {
            status = document.createElement('div');
            status.className = 'single-form__status';
            form.appendChild(status);
        }

        form.addEventListener('submit', function(e){
            e.preventDefault();
            
            // Очищаем предыдущий статус
            status.textContent = '';
            status.className = 'single-form__status';
            
            // Получаем данные формы
            const fd = new FormData(form);
            
            // Добавляем название услуги
            const serviceName = getServiceName();
            fd.append('service_name', serviceName);
            
            // Добавляем стандартные поля для AJAX
            fd.append('action', 'send_contact_request');
            fd.append('nonce', (window.ServiceFormAjax && ServiceFormAjax.nonce) ? ServiceFormAjax.nonce : '');
            fd.append('page', window.location.href);
            
            // Отключаем кнопку отправки
            const submitBtn = form.querySelector('.single-form__btn');
            const originalBtnText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
            }

            fetch((window.ServiceFormAjax && ServiceFormAjax.ajaxurl) ? ServiceFormAjax.ajaxurl : '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json()).then(data => {
                if (data && data.success) {
                    status.className = 'single-form__status success';
                    status.textContent = (window.ServiceFormAjax && ServiceFormAjax.successMessage) ? ServiceFormAjax.successMessage : 'Заявка успешно отправлена!';
                    form.reset();
                    
                    // Восстанавливаем кнопку
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalBtnText;
                    }
                } else {
                    status.className = 'single-form__status error';
                    status.textContent = (data && data.data && data.data.message) ? data.data.message : ((window.ServiceFormAjax && ServiceFormAjax.errorMessage) ? ServiceFormAjax.errorMessage : 'Произошла ошибка. Попробуйте позже.');
                    
                    // Восстанавливаем кнопку
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalBtnText;
                    }
                }
            }).catch(() => {
                status.className = 'single-form__status error';
                status.textContent = (window.ServiceFormAjax && ServiceFormAjax.errorMessage) ? ServiceFormAjax.errorMessage : 'Произошла ошибка. Попробуйте позже.';
                
                // Восстанавливаем кнопку
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            });
        });
    }
    
    // Инициализируем форму
    initServiceForm();
    
    // Если форма еще не загружена, попробуем инициализировать позже
    if (!document.querySelector('.single-form__form')) {
        const formObserver = new MutationObserver(function() {
            const form = document.querySelector('.single-form__form');
            if (form && form.dataset.initialized !== 'true') {
                initServiceForm();
                if (form.dataset.initialized === 'true') {
                    formObserver.disconnect();
                }
            }
        });
        formObserver.observe(document.body, { childList: true, subtree: true });
    }
});


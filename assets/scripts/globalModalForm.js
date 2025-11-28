document.addEventListener('DOMContentLoaded', function() {
    // Создаём оверлей модалки если его нет
    let modal = document.getElementById('globalModalContact');
    let overlay = document.getElementById('globalModalOverlay');

    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'globalModalOverlay';
        overlay.style.display = 'none';
        overlay.style.position = 'fixed';
        overlay.style.zIndex = '9998';
        overlay.style.left = '0';
        overlay.style.top = '0';
        overlay.style.width = '100vw';
        overlay.style.height = '100vh';
        overlay.style.background = 'rgba(0,0,0,0.35)';
        document.body.appendChild(overlay);
    }

    function getModal() {
        if (!modal) {
            modal = document.getElementById('globalModalContact');
        }
        return modal;
    }

    function showModal() {
        const currentModal = getModal();
        if (!currentModal) {
            console.warn('Модальное окно не найдено');
            return;
        }
        overlay.style.display = 'block';
        currentModal.style.display = 'block';
        setTimeout(() => {
            overlay.classList.add('active');
            currentModal.classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function hideModal() {
        const currentModal = getModal();
        if (!currentModal) return;
        overlay.classList.remove('active');
        currentModal.classList.remove('active');
        setTimeout(() => {
            overlay.style.display = 'none';
            currentModal.style.display = 'none';
            document.body.style.overflow = '';
        }, 180);
    }
    // События открытия
    document.querySelectorAll('.js-modal-contact').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showModal();
        });
    });
    // События закрытия
    if (overlay) {
        overlay.addEventListener('click', hideModal);
    }
    document.addEventListener('keydown', function(e){
        const currentModal = getModal();
        if (currentModal && currentModal.classList.contains('active') && (e.key === 'Escape')) {
            hideModal();
        }
    });
    
    // Обработчик закрытия по кнопке
    function initModalClose() {
        const currentModal = getModal();
        if (currentModal) {
            currentModal.addEventListener('click', function (e) {
                if (e.target.classList.contains('modal-contact__close')) {
                    hideModal();
                }
            });
        }
    }
    initModalClose();
    
    // Если модалка еще не загружена, попробуем инициализировать позже
    if (!modal) {
        const observer = new MutationObserver(function() {
            if (document.getElementById('globalModalContact')) {
                initModalClose();
                observer.disconnect();
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

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

    bindPhoneMask(document);
    
    // Флаг для предотвращения множественной инициализации
    let formInitialized = false;
    
    // Инициализация формы (может быть вызвана позже, если модалка загружается динамически)
    function initForm() {
        const currentModal = getModal();
        if (!currentModal || formInitialized) return;
        
        // AJAX submit
        const form = currentModal.querySelector('.modal-contact__form');
        if (form) {
            // Проверяем, не добавлен ли уже обработчик
            if (form.dataset.initialized === 'true') return;
            form.dataset.initialized = 'true';
            
            // Проверяем, не добавлен ли уже статус
            let status = form.querySelector('.modal-contact__status');
            if (!status) {
                status = document.createElement('div');
                status.className = 'modal-contact__status';
                status.style.marginTop = '6px';
                status.style.fontSize = '13px';
                form.appendChild(status);
            }

            form.addEventListener('submit', function(e){
                e.preventDefault();
                status.textContent = '';
                const fd = new FormData(form);
                fd.append('action', 'send_contact_request');
                fd.append('nonce', (window.ModalFormAjax && ModalFormAjax.nonce) ? ModalFormAjax.nonce : '');
                fd.append('page', window.location.href);

                fetch((window.ModalFormAjax && ModalFormAjax.ajaxurl) ? ModalFormAjax.ajaxurl : '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json()).then(data => {
                    if (data && data.success) {
                        status.style.color = '#1a7f37';
                        status.textContent = (window.ModalFormAjax && ModalFormAjax.successMessage) ? ModalFormAjax.successMessage : 'Отправлено.';
                        form.reset();
                        // закрыть через паузу
                        setTimeout(hideModal, 1000);
                    } else {
                        status.style.color = '#cc1f1a';
                        status.textContent = (data && data.data && data.data.message) ? data.data.message : ((window.ModalFormAjax && ModalFormAjax.errorMessage) ? ModalFormAjax.errorMessage : 'Ошибка.');
                    }
                }).catch(() => {
                    status.style.color = '#cc1f1a';
                    status.textContent = (window.ModalFormAjax && ModalFormAjax.errorMessage) ? ModalFormAjax.errorMessage : 'Ошибка.';
                });
            });
            
            // На случай динамического рендера внутри модалки
            const observer = new MutationObserver(() => bindPhoneMask(currentModal));
            observer.observe(currentModal, { childList: true, subtree: true });
            
            formInitialized = true;
        }
    }
    
    // Инициализируем форму сразу или позже
    initForm();
    
    // Если модалка еще не загружена, попробуем инициализировать позже
    if (!getModal() || !formInitialized) {
        const formObserver = new MutationObserver(function() {
            const currentModal = getModal();
            if (currentModal && currentModal.querySelector('.modal-contact__form') && !formInitialized) {
                initForm();
                if (formInitialized) {
                    formObserver.disconnect();
                }
            }
        });
        formObserver.observe(document.body, { childList: true, subtree: true });
    }
});

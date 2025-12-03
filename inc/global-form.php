<?php
/**
 * Отправка сообщения в Telegram через Bot API
 * 
 * @param string $message Текст сообщения
 * @return bool Успешно ли отправлено
 */
function finspace_send_telegram_message($message) {
    // Получаем настройки из опций WordPress
    // Используем правильные ключи опций
    $bot_token = get_option('finspace_telegram_bot_token', '8556802157:AAGUbeLhbI_EEm1roW42SNiNxCi8pc7CC-0');
    $chat_id = get_option('finspace_telegram_chat_id', '-1003451700386');
    
    // Если не настроено, возвращаем false
    if (empty($bot_token) || empty($chat_id)) {
        error_log('Telegram: Не указан токен бота или chat_id');
        return false;
    }
    
    $url = 'https://api.telegram.org/bot' . $bot_token . '/sendMessage';
    
    $data = array(
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML',
    );
    
    $args = array(
        'body' => $data,
        'timeout' => 10,
        'sslverify' => true,
    );
    
    $response = wp_remote_post($url, $args);
    
    if (is_wp_error($response)) {
        error_log('Telegram ошибка: ' . $response->get_error_message());
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);
    
    if (!isset($result['ok']) || $result['ok'] !== true) {
        $error_desc = isset($result['description']) ? $result['description'] : 'Неизвестная ошибка';
        error_log('Telegram API ошибка: ' . $error_desc);
        return false;
    }
    
    return true;
}

function finspace_send_contact_request() {
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['nonce']) ), 'modal_form_nonce' ) ) {
        wp_send_json_error(array('message' => 'Неверный nonce')); exit;
    }
    $name    = isset($_POST['name']) ? sanitize_text_field( wp_unslash($_POST['name']) ) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field( wp_unslash($_POST['phone']) ) : '';
    $email   = isset($_POST['email']) ? sanitize_text_field( wp_unslash($_POST['email']) ) : '';
    $comment = isset($_POST['comment']) ? sanitize_textarea_field( wp_unslash($_POST['comment']) ) : '';
    $privacy = isset($_POST['privacy']) ? (int) $_POST['privacy'] : 0;
    $service_name = isset($_POST['service_name']) ? sanitize_text_field( wp_unslash($_POST['service_name']) ) : '';

    // Для формы услуг проверяем только телефон и privacy (name не обязателен)
    if ( ! empty($service_name) ) {
        // Это форма услуги - проверяем только телефон и privacy
        if ( empty($phone) || ! $privacy ) {
            wp_send_json_error(array('message' => 'Заполните обязательные поля.')); exit;
        }
    } else {
        // Это обычная форма - проверяем name, phone и privacy
        if ( empty($name) || empty($phone) || ! $privacy ) {
            wp_send_json_error(array('message' => 'Заполните обязательные поля.')); exit;
        }
    }
    if ( ! empty($email) && ! is_email($email) ) {
        wp_send_json_error(array('message' => 'Некорректный email.')); exit;
    }

    $site_name = wp_specialchars_decode( get_bloginfo('name'), ENT_QUOTES );
    $subject = 'Новая заявка с сайта: ' . $site_name;

    $body_lines = array();
    if ( ! empty($service_name) ) {
        $body_lines[] = 'Услуга: ' . $service_name;
    }
    if ( ! empty($name) ) {
        $body_lines[] = 'Имя: ' . $name;
    }
    $body_lines[] = 'Телефон: ' . $phone;
    if ( ! empty($email) ) { $body_lines[] = 'Email: ' . $email; }
    if ( ! empty($comment) ) { $body_lines[] = 'Комментарий: ' . $comment; }
    $body_lines[] = 'Страница: ' . ( isset($_POST['page']) ? esc_url_raw( wp_unslash($_POST['page']) ) : home_url('/') );
    $message = implode("\n", $body_lines);

    // Заголовки письма
    // ВАЖНО: Не задаем From вручную - пусть плагин SMTP управляет этим
    // Это нужно чтобы адрес From совпадал с адресом SMTP аутентификации
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . (!empty($email) ? sanitize_email($email) : get_option('admin_email'))
    );

    // Отправляем на каждую почту отдельно для лучшей надежности
    $recipients = array('empry.test@mail.ru', '79185074947@yandex.ru');
    $sent_email = false;
    
    foreach ($recipients as $recipient) {
        $result = wp_mail( $recipient, $subject, $message, $headers );
        if ($result) {
            $sent_email = true;
        }
    }

    // Формируем сообщение для Telegram с HTML форматированием
    $telegram_message = "<b>📧 Новая заявка с сайта</b>\n\n";
    if ( ! empty($service_name) ) {
        $telegram_message .= "<b>Услуга:</b> " . esc_html($service_name) . "\n";
    }
    if ( ! empty($name) ) {
        $telegram_message .= "<b>Имя:</b> " . esc_html($name) . "\n";
    }
    $telegram_message .= "<b>Телефон:</b> " . esc_html($phone) . "\n";
    if ( ! empty($email) ) {
        $telegram_message .= "<b>Email:</b> " . esc_html($email) . "\n";
    }
    if ( ! empty($comment) ) {
        $telegram_message .= "<b>Комментарий:</b> " . esc_html($comment) . "\n";
    }
    $telegram_message .= "<b>Страница:</b> " . ( isset($_POST['page']) ? esc_url_raw( wp_unslash($_POST['page']) ) : home_url('/') );
    
    // Отправляем в Telegram (не блокируем отправку, если не настроено)
    $sent_telegram = finspace_send_telegram_message($telegram_message);

    // Форма считается отправленной, если отправлено хотя бы на почту
    if ( $sent_email ) {
        wp_send_json_success(array('message' => 'Отправлено'));
    } else {
        wp_send_json_error(array('message' => 'Не удалось отправить.'));
    }
    exit;
}

// Регистрация AJAX обработчика
add_action('wp_ajax_send_contact_request', 'finspace_send_contact_request');
add_action('wp_ajax_nopriv_send_contact_request', 'finspace_send_contact_request');

// Локализация скрипта для передачи nonce и ajaxurl
function vbrand_localize_modal_form_script() {
    // Локализуем скрипт после его регистрации
    wp_localize_script('global-form', 'ModalFormAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('modal_form_nonce'),
        'successMessage' => 'Заявка успешно отправлена!',
        'errorMessage' => 'Произошла ошибка. Попробуйте позже.'
    ));
    
    // Локализация для формы услуг
    if ( is_singular( 'services' ) ) {
        wp_localize_script('services-form', 'ServiceFormAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('modal_form_nonce'),
            'successMessage' => 'Заявка успешно отправлена!',
            'errorMessage' => 'Произошла ошибка. Попробуйте позже.'
        ));
    }
}
// Используем приоритет выше, чем у enqueue_scripts, чтобы скрипт был уже зарегистрирован
add_action('wp_enqueue_scripts', 'vbrand_localize_modal_form_script', 15);
<div id="globalModalContact" style="display:none;" role="dialog" aria-modal="true">
    <button type="button" class="modal-contact__close">×</button>
    <div class="modal-contact__inner">
        <div class="modal-contact__title">Оставить заявку</div>
        <form class="modal-contact__form">
            <input type="text" name="name" placeholder="Ваше имя*" required class="modal-contact__input">
            <input type="tel" name="phone" placeholder="Телефон*" required class="modal-contact__input">
            <input type="email" name="email" placeholder="Email" class="modal-contact__input">
            <textarea name="comment" rows="3" placeholder="Комментарий" class="modal-contact__textarea"></textarea>
            <label class="modal-contact__privacy">
                <input type="checkbox" name="privacy" value="1" required>
                <span>
                    Нажимая на кнопку, я даю согласие на
                    <a href="/privacy/" target="_blank" rel="noopener">обработку персональных данных</a>
                    и
                    <a href="/policy/" target="_blank" rel="noopener">политику конфиденциальности</a>
                </span>
            </label>
            <button type="submit" class="modal-contact__submit">Отправить заявку</button>
        </form>
    </div>
</div>

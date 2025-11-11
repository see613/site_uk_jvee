<div id="main">
    <img class="collage" src="images/main_img.png" alt="" />
    <img class="slogan2" src="images/slogan2.png" alt="ДЕЙСТВУЙ: БОЛЬШЕ" />

    <section class="content confirm">
        <h1>Подтверждение регистрации</h1>
        <h3>Поздравляем с успешно сохраненной анкетой <br />на сайте промо акции Rexona! </h3>
        <p>Для завершения регистрации необходимо подтвердить контакты. Пожалуйста, укажи код, который был отправлен тебе на номер телефона, указанный в анкете.</p>
        <form>
            <div class="row">
                <div class="input"><input type="text" value="" class="text" /> <input type="button" value="Подтвердить" class="button" /></div>
            </div>
        </form>

        <?php if( Yii::app()->user->hasFlash('accept_phone_message') ): ?>
        <p style="color: green"><?php echo Yii::app()->user->getFlash('accept_phone_message') ?></p>
        <?php endif ?>

        <hr class="border" />
        <p>Если не волучили СМС с кодом подтверждения, проверь, пожалуйста, номер мобильного телефона, указанный тобой в анкете, и повтори отправку СМС</p>
        <div class="tel">+7(915)123-45-67 <a href="/profile/accept/phone" class="button">Повторить отправку кода</a></div>
        <div class="clr"></div>
    </section>
</div>
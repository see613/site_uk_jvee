
<style>
.accept-message{ color: green; font-weight: bold }
</style>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'login-form'
)); ?>

<div class="row">
    <h2>Авторизация</h2>
</div>

<?php if( Yii::app()->user->getFlash('accept_email_message') ): ?>
<div class="row accept-message">
    Ссылка для активации аккаунта отправлена на ваш email
</div>
<?php endif ?>

<div class="row control-group <?php echo $model->hasErrors('username') ? 'error' : '' ?>">
    <span class="row_name">E-mail или логин:</span>
    <div class="input">
        <?php echo $form->textField($model, 'username', array('class'=>'text', 'placeholder' => 'Введите email')); ?>
        <?php if($model->hasErrors('username')): ?><span class="help-inline"><?php echo $model->getError('username') ?></span><?php endif ?>
    </div>
</div>

<div class="row control-group <?php echo $model->hasErrors('password') ? 'error' : '' ?>">
    <span class="row_name">Пароль:</span>
    <div class="input">
        <?php echo $form->PasswordField($model, 'password', array('class'=>'text', 'placeholder' => 'Введите пароль')); ?>
        <?php if($model->hasErrors('password')): ?><span class="help-inline"><?php echo $model->getError('password') ?></span><?php endif ?>
    </div>
</div>

<div class="row control-group ">
    <label>
    <?php echo $form->Checkbox($model, 'rememberMe'); ?> Запомнить
    </label>
</div>

<div class="row">
     <?php echo CHtml::submitButton('Войти', array( 'class' => 'btn' )); ?>
</div>

<?php $this->endWidget(); ?>

<div class="row">
<p>Войти через:
<a href="/oauth/service/vk">Вконтакте</a>
<a href="/oauth/service/fb">Facebook</a>
<a href="/oauth/service/ok">Одноклассники</a>
<a href="/oauth/service/mail">Мой мир</a>
</p>
<p><a href="/registration/recovery">Регистрация</a></p>
<p><a href="/registration/recovery">Восстановление пароля</a></p>
</div>
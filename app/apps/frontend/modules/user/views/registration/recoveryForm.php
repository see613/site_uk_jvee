
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'remind-password-form'
)); ?>

<div class="row">
<h2>Восстановление пароля</h2>
</div>

<div class="row control-group <?php echo $model->hasErrors('email') ? 'error' : '' ?>">
    <span class="row_name">E-mail<span class="ast">*</span>:</span>
    <div class="input">
        <?php echo $form->textField($model, 'email', array('class'=>'text', 'placeholder' => 'Введите email')); ?>
        <?php if($model->hasErrors('email')): ?><span class="help-inline"><?php echo $model->getError('email') ?></span><?php endif ?>
    </div>
</div>

<?php $captcha = $this->beginWidget('WCaptcha', array('model'=>$model, 'attribute'=>'captcha', 'captchaAction'=>'captcha_recovery')); ?>
<div class="row control-group <?php echo $model->hasErrors('captcha') ? 'error' : '' ?>">
    <span class="row_name">Введи код с картинки<span class="ast">*</span>:</span>
    <div class="input <?php echo $model->hasErrors('captcha') ? 'error' : '' ?>">
        <?php echo $form->TextField($model, 'captcha', array('class'=>'text', 'value' => '')); ?>
        <?php if($model->hasErrors('captcha')): ?><span class="help-inline"><?php echo $model->getError('captcha') ?></span><?php endif ?>
    </div>
    <div class="capcha_img">
        <a class="refresh <?php echo $captcha->refreshClass() ?>">Обновить</a><br/>
        <?php echo $captcha->renderImage() ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<div class="row">
    <?php echo CHtml::submitButton('Восстановить', array( 'class' => 'btn' )); ?>
</div>

<?php $this->endWidget(); ?>
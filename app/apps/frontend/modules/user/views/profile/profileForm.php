<style>
.refresh{ cursor: pointer; }
.sex_man{ float: left; }
.sex_woman{ float: left; margin: 0 5px 0 15px }
.birth_day, .birth_month, .birth_year { width: 70px }
.row.agree{ margin-top: 10px }
.profile_saved{ color: green; margin-bottom: 10px }
</style>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'profile-form'
)); ?>

<?php //$list = $model->getErrors(); ?>
<?php //foreach($list as $error): ?>
<!--<p class="error_text"><?php //echo $error[0] ?></p>-->
<?php //endforeach ?>

<div>

    <div class="row">
    <h2>Личный кабинет</h2>
    </div>

    <?php if( Yii::app()->user->getFlash('profile_has_saved') ): ?>
    <div class="row profile_saved">Данные успешно сохранены</div>
    <?php endif ?>

    <div class="row control-group <?php echo $model->hasErrors('last_name') ? 'error' : '' ?>">
        <span class="row_name">Фамилия<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->textField($model, 'last_name', array('class'=>'text', 'placeholder' => 'Введите фамилию')); ?>
            <?php if($model->hasErrors('last_name')): ?><span class="help-inline"><?php echo $model->getError('last_name') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('first_name') ? 'error' : '' ?>">
        <span class="row_name">Имя<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->textField($model, 'first_name', array('class'=>'text', 'placeholder' => 'Введите имя')); ?>
            <?php if($model->hasErrors('first_name')): ?><span class="help-inline"><?php echo $model->getError('first_name') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('middle_name') ? 'error' : '' ?>">
        <span class="row_name">Отчество:</span>
        <div class="input">
            <?php echo $form->textField($model, 'middle_name', array('class'=>'text', 'placeholder' => 'Введите отчество')); ?>
            <?php if($model->hasErrors('middle_name')): ?><span class="help-inline"><?php echo $model->getError('middle_name') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('sex') ? 'error' : '' ?>">
        <span class="row_name">Пол<span class="ast">*</span>:</span>
        <div class="input">
            <div class="sex_man"><label><input <?php echo $model->sex == '1' ? 'checked="checked"' : '' ?> type="radio" name="sex" onchange="$('.sex-field').val('1')" class="radio" /> Мужской</label></div>
            <div class="sex_woman"><label><input <?php echo $model->sex == '2' ? 'checked="checked"' : '' ?> type="radio" name="sex" onchange="$('.sex-field').val('2')" class="radio" /> Женский</label></div>
            <?php echo $form->hiddenField($model, 'sex', array('class' => 'sex-field')); ?>
            <?php if($model->hasErrors('sex')): ?><span class="help-inline"><?php echo $model->getError('sex') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('email') ? 'error' : '' ?>">
        <span class="row_name">Контактный e-mail<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->textField($model, 'email', array('class'=>'text', 'placeholder' => 'Введите email')); ?>
            <?php if($model->hasErrors('email')): ?><span class="help-inline"><?php echo $model->getError('email') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('phone') ? 'error' : '' ?>">
        <span class="row_name">Мобильный телефон<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->textField($model, 'phone', array('class'=>'text', 'placeholder' => 'Введите номер телефона')); ?>
            <?php if($model->hasErrors('phone')): ?><span class="help-inline"><?php echo $model->getError('phone') ?></span><?php endif ?>
        </div>
    </div>

    <?php $monthList = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'); ?>
    <div class="row control-group <?php echo $model->hasErrors('birthday') ? 'error' : '' ?>">
        <span class="row_name">Дата рождения:</span>
        <div class="select">
            <?php echo $form->dropDownList($model,'birthday_day', array_combine( range(1, 31), range(1, 31) ), array('empty' => '', 'class' => 'birth_day')); ?>
            <?php echo $form->dropDownList($model,'birthday_month', array_combine( range(1, 12), $monthList ), array('empty' => '', 'class' => 'birth_month')); ?>
            <?php echo $form->dropDownList($model,'birthday_year', array_combine( range(1950, 2013), range(1950, 2013) ), array('empty' => '', 'class' => 'birth_year')); ?>

            <?php if($model->hasErrors('birthday')): ?><span class="help-inline"><?php echo $model->getError('birthday') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('password') ? 'error' : '' ?>">
        <span class="row_name">Пароль<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->PasswordField($model, 'password', array('class'=>'text', 'placeholder' => 'Введите пароль', 'value' => '')); ?>
            <?php if($model->hasErrors('password')): ?><span class="help-inline"><?php echo $model->getError('password') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row control-group <?php echo $model->hasErrors('password_repeat') ? 'error' : '' ?>">
        <span class="row_name">Повторите пароль<span class="ast">*</span>:</span>
        <div class="input">
            <?php echo $form->PasswordField($model, 'password_repeat', array('class'=>'text', 'placeholder' => 'Повторите пароль')); ?>
            <?php if($model->hasErrors('password_repeat')): ?><span class="help-inline"><?php echo $model->getError('password_repeat') ?></span><?php endif ?>
        </div>
    </div>

    <div class="row">
        <?php echo CHtml::submitButton('Сохранить', array( 'class' => 'btn' )); ?>
    </div>

    <div class="row agree"><p class="small">Поля отмеченные * обязательны для заполнения</p></div>

</div>

<?php $this->endWidget(); ?>
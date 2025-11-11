<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'activity-log-form',
	'enableAjaxValidation'=>false,
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>

	<?php echo $form->errorSummary($model); ?>

    <div class="admin-field-block">
	<?php echo $form->labelEx($model,'action_id');echo $form->textField($model,'action_id',array('class'=>'span5','maxlength'=>11));; ?>
    </div>
    <div class="admin-field-block">
	<?php echo $form->labelEx($model,'user_id');echo $form->textField($model,'user_id',array('class'=>'span5','maxlength'=>11));; ?>
    </div>
    <div class="admin-field-block">
	<?php echo $form->labelEx($model,'score');echo $form->textField($model,'score',array('class'=>'span5','maxlength'=>11));; ?>
    </div>
    <div class="admin-field-block">
	<?php echo $form->labelEx($model,'created_at');echo $form->textField($model,'created_at',array('class'=>'span5'));; ?>
    </div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.CREATE') : Yii::t('Bootstrap', 'PHRASE.SAVE'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>

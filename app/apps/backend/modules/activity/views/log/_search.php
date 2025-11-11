<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo echo $form->labelEx($model,'id');echo $form->textField($model,'id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->labelEx($model,'activity_id');echo $form->textField($model,'activity_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->labelEx($model,'user_id');echo $form->textField($model,'user_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->labelEx($model,'family_id');echo $form->textField($model,'family_id',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->labelEx($model,'score');echo $form->textField($model,'score',array('class'=>'span5','maxlength'=>11));; ?>

	<?php echo echo $form->labelEx($model,'created_at');echo $form->textField($model,'created_at',array('class'=>'span5'));; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('Phrases', 'LOGIN');

$this->layout = '//layouts/access';
?>

<?php
	$css = '
		form.form-vertical {
			margin-bottom: 0;
		}

		div.form {
			/* align center */
			position: absolute;

			top: 50%;
			margin-top: -166px;

			left: 50%;
			margin-left: -175px !important;

			/* sizing */
			width: 310px;
			height: 332px;
			margin-left: auto;
			margin-right: auto;

			padding-left: 20px;
			padding-right: 20px;

			/*styles*/
			-webkit-box-shadow: 1px 1px 30px rgba(50, 50, 50, 0.69);
			-moz-box-shadow:    1px 1px 30px rgba(50, 50, 50, 0.69);
			box-shadow:         1px 1px 30px rgba(50, 50, 50, 0.69);
		}

		div.form-actions {
			padding-left: 20px !important;
		}

		div.controls {
			margin-left: 0 !important;
		}
	';
	Yii::app()->clientScript->registerCss(get_class($model).'.form', $css);
?>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),

	'htmlOptions'=>array('class'=>'form-vertical'),
)); ?>

<legend><?php echo Yii::t('Phrases', 'LOGIN') ?></legend>

<fieldset>
	<div class="control-group">
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><span class="icon-user"></span></span>
				<?php echo $form->textField($model,'username', array('class'=>'input-xlarge')); ?>
			</div>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><span class="icon-lock"></span></span>
				<?php echo $form->passwordField($model,'password',array('class'=>'input-xlarge')); ?>
			</div>
		</div>
	</div>

	<span class="help-block"><?php echo Yii::t('Phrases', 'BACKEND.LOGIN_WELCOME') ?></span>
	<?php //echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
			<span class="pull-left">
				<label class="checkbox">
					<?php echo $form->checkBox($model,'rememberMe',array()); ?>
					<?php echo CHtml::encode($model->getAttributeLabel('rememberMe'))?>
				</label>
			</span>

			<span class="pull-right">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>Yii::t('Phrases', 'LOGIN'),
				)); ?>
			</span>
	</div>

</fieldset>

<?php $this->endWidget(); ?>

</div>
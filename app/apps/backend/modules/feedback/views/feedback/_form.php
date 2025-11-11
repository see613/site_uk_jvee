

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'feedback-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>

<!-- Fields with <span class="required">*</span> are required. -->
<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255));; ?>
<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>255));; ?>
<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255));; ?>
<?php echo $form->textAreaRow($model,'message',array('class'=>'span5'));; ?>



<?php echo $form->DatePickerRow($model, 'created_at', array(
    'options'=>array(
        'autoclose' => true,
        //'showAnim'=>'fold',
        'type' => 'Component',
        'format'=>'yyyy-mm-dd',
    ),
    'htmlOptions'=>array(
        //'value'=> strlen($model->created_at) > 0 ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->created_at) : '',
        //'class'=>'span2'
    ),
));; ?>

<div class="form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px'),
        'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        //'type'=>'primary',
        'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
        'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'link',
        'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
        'url' =>$this->listUrl('index'),
    )); ?>

</div>

<?php $this->endWidget(); ?>

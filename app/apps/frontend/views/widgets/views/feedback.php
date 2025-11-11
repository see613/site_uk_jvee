
<?php
$submitUrl = Yii::app()->baseUrl.'/contact/submitwidget';
$formId = 'feedback-form';

$form=$this->beginWidget('CActiveForm', array(
    'action'=>$submitUrl,
    'id' => $formId,
    'enableAjaxValidation' => true
)); ?>
    <div>
        <div class="flex">
            <div class="bold font-20 dark-blue">
                GET IN TOUCH
            </div>
            <div>
                <?php echo $form->textField($model, 'name', ['placeholder'=>'Name*']); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div>
                <?php echo $form->textField($model, 'phone', ['placeholder'=>'Telephone']); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
            <div>
                <?php echo $form->textField($model, 'email', ['placeholder'=>'Email*']); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div>
                <?php $this->widget('ReCaptchaWidget',
                    array(
                        'theme'=>ReCaptchaWidget::THEME_LIGHT,
                        'publicKey' => RECAPTCHA_PUBLIC_KEY,
                        'language' => 'en'
                    ), false); ?>

                <?php echo CHtml::submitButton(
                    'SEND',
                    array(
                        'class'=>"",
                        'id'=>"feedback-submit"
                    ));
                ?>
            </div>
        </div>
        <div class="center font-14">
            Contacting us really does matter to JV Electrical Essex, and we promise to respond promptly.
        </div>
    </div>

<?php $this->endWidget(); ?>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="my-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Thank you for contacting us.<br />
                We will respond to you as soon as possible
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
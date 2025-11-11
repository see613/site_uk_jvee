
<?php
$submitUrl = Yii::app()->baseUrl.'/contact/submit';
$formId = 'contact-form';

$form=$this->beginWidget('CActiveForm', array(
    'action'=>$submitUrl,
    'id' => $formId,
    'enableAjaxValidation' => true,
    'htmlOptions'=>array(
        'class'=>''
    )
)); ?>

    <div class="row">
        <div class="col-sm-12">
           <p class="font-23 bold">
               Get in Touch
           </p>
            <p class="font-20 mb-25">
                Please fill out the form below and we will get back to you as soon as possible.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 field-wrapper mb-25">
            <?=$form->textField($model, 'name', [
                'placeholder'=>'NAME*',
            ]); ?>
            <?=$form->error($model, 'name'); ?>
        </div>
        <div class="col-sm-6 field-wrapper mb-25">
            <?=$form->textField($model, 'phone', [
                'placeholder'=>'TELEPHONE*',
            ]); ?>
            <?=$form->error($model, 'phone'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 field-wrapper mb-25">
            <?=$form->textField($model, 'email', [
                'placeholder'=>'EMAIL*',
            ]); ?>
            <?=$form->error($model, 'email'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 field-wrapper mb-25">
            <?=$form->textArea($model, 'message', [
                'placeholder'=>'MESSAGE*',
            ]); ?>
            <?=$form->error($model, 'message'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 right center-xs-max mb-25">
            <?php $this->widget('ReCaptchaWidget',
                [
                    'theme'=>ReCaptchaWidget::THEME_LIGHT,
                    'publicKey' => RECAPTCHA_PUBLIC_KEY,
                    'language' => 'en'
                ], false); ?>

            <?=CHtml::submitButton(
                'SEND',
                [
                    'class'=>"hidden",
                    'id'=>"contact-submit"
                ]);
            ?>

            <button class="send-it-button submit arrow-button">
                SEND IT
                <span class="bg"></span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 right mb-15">
            <div class="allowance-wrapper">
                <div>
                    <?=$form->checkBox($model, 'allowance', ['uncheckValue'=>''])?>
                </div>
                <div>
                    <label for="Feedback_allowance" class="">
                        By clicking this box, you confirm that you have read, understood, and agree to be bound by our Terms of Use and Privacy Policy.<br class="hide-sm-max">
                        We share your information with no one, and only use the information to contact you as you have requested.
                    </label>
                </div>
            </div>
            <?=$form->error($model, 'allowance'); ?>
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
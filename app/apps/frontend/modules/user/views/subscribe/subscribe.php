<!-- основной скрипт формы -->

<?php /*задержка для скрытия тултипа "Вы подписались"*/ $tooltipDelay = 8000 ?>

<script type="text/javascript">
jQuery(function() {
    var formId = "<?php echo WRemoteForm::buildFormId($model) ?>";
    
    $("#"+formId)
         .on("start", function() {
            $("#"+formId+"-success").hide();
            
         })
         .on("end", function() {
            $(document).trigger("captcha.refresh");
            $("#<?php echo CHtml::activeId($model, 'captcha') ?>").val("");
         })
         .on("success", function () {
            //очистка полей
            $("#"+formId + ' input[type="text"]').each(function () {
                $(this).val("");
            });
            
            $("#"+formId+"-success").fadeIn(200);
            //скроллинг страницы в топ
            $("body,html").animate({scrollTop:0}, 800);
            //hide tooltip delay
            setTimeout(function () {
                $("#"+formId+"-success").fadeOut(200);
            }, <?php echo $tooltipDelay ?>);
         });
});
</script>

<div class="border_block forms_block newsletter">

<!-- форма-виджет -->
<?php $form = $this->beginWidget('WRemoteForm', array(
    'action'=>array('/jusers/subscribe'),
    'model'=>$model,
));?>

<!-- блоки ошибок и успешной подписки -->
<?php echo $form->errors(array('class'=>'form-block-errors', 'style'=>'padding-right: 0')) ?>
<?php echo CHtml::openTag('div', array('id'=>$form->getFormId().'-success', 'class'=>'form-block-success', 'style'=>'margin-right: 0; display: none;')) ?>
    Вы успешно подписались на новости. Для управления подпиской воспользуйтесь письмом, отправленным на Ваш email. 
<?php echo CHtml::closeTag('div'); ?>
<div>
    <!-- Left Column -->
    <div class="col">

        <!-- First Name -->
        <?php $this->beginWidget('WInputRow', array('model'=>$model, 'attribute'=>'first_name', 'required_string' => '<font style="color:red">*</font>')) ?>
            <?php echo CHtml::activeTextField($model, 'first_name') ?>
        <?php $this->endWidget() ?>

        <!-- Email -->
        <?php $this->beginWidget('WInputRow', array('model'=>$model, 'attribute'=>'email', 'required_string' => '<font style="color:red">*</font>')) ?>
            <?php echo CHtml::activeTextField($model, 'email') ?>
        <?php $this->endWidget() ?>

        <!-- Captcha -->

        <?php $this->widget('WCaptcha', array('model'=>$model, 'attribute'=>'captcha', 'captchaAction'=>'captcha_subscribe', 'required_string' => '<font style="color:red">*</font>')) ?>

    </div>

    <div class="text">
        <h3 class="normal">Если Вы захотите поменять адрес подписки или отписаться от нее</h3>
        <p>Перейдите в <a href="/profile">личный кабинет</a></p>
    </div>
</div>
    <div style="clear: left;"></div>
    <div class="text"></div>

    <?php $this->widget('WCheckBox', array('model'=>$model, 'attribute'=>'accept_process')) ?>

    <div class="input_block">
        <button class="button"><span>Подписаться</span></button>
    </div>
    
    <div class="clr">&nbsp;</div>
    
    <p><font style="color:red">*</font> Поля обязательные для заполнения.</p>
                                
<?php $this->endWidget(); ?>
</div>

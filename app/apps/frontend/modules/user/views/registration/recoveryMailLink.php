Здавствуйте, <?php echo $model->first_name ?><br/><br/>
Команде поддержки сайта <?php echo CHtml::link( $_SERVER['HTTP_HOST'] , Yii::app()->createAbsoluteUrl('/')) ?> поступила информация об изменении пароля, указанного Вами при регистрации.<br/>
Для сброса пароля вашего аккаунта, пожалуйста, пройдите по следующей ссылке:
<?php echo CHtml::link(
    Yii::app()->createAbsoluteUrl('/registration/recovery/' . $model->recovery_code),
    Yii::app()->createAbsoluteUrl( '/registration/recovery/' . $model->recovery_code )
); ?>
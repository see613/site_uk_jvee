Здавствуйте, <?php echo $model->first_name ?><br/><br/>
Вы зарегистрировались на сайте <?php echo CHtml::link( $_SERVER['HTTP_HOST'] , Yii::app()->createAbsoluteUrl('/')) ?><br/>
Для активации вашего аккаунта, пожалуйста, пройдите по следующей ссылке:
<?php echo CHtml::link(
    Yii::app()->createAbsoluteUrl('/registration/accept/' . $model->email_accept_code),
    Yii::app()->createAbsoluteUrl( '/registration/accept/' . $model->email_accept_code )
); ?>
<br/>
<h3 style="font-family:Arial; font-size: 15px; color: #888888; margin-top:0;line-height: 22px">Пользователь, <?php echo $user->first_name ?> <?php echo $user->last_name ?> добавил информацию о коде</h3>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Подронее по ссылке: <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('/admin/activity/code/update/id/' . $code->id ), Yii::app()->createAbsoluteUrl('/admin/activity/code/update/id/' . $code->id ) ) ?>
</p>
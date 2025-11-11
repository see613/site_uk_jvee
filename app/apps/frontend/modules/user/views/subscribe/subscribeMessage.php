<h3 style="font-family:Arial; font-size: 15px; color: #888888; margin-top:0;line-height: 22px">Здравствуйте, <?php echo $model['first_name'] ?>!</h3>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Команде поддержки сайта www.johnsonsbaby.ru поступила информация о регистрации нового подсчика.
</p>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Мы рады приветствовать Вас на нашем сайте, посвященном уходу и заботе о малышах, самых дорогих и любимых непоседах!
</p>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Ваш пароль : <strong><?php echo $password ?></strong>
</p>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Для активации аккаунта, смены пароля и управления подпиской на сайте www.johnsonsbaby.ru, пройдите по <?php echo CHtml::link('ссылке', Yii::app()->createAbsoluteUrl('/jusers/register/activate', array('key'=>$model['activation_code'], 'id'=>$model['id']))) ?>
</p>

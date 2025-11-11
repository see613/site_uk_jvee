Здавствуйте, <?php echo $model->first_name ?><br/><br/>
Ваш пароль для доступа в личный кабинет на сайте  <?php echo CHtml::link( $_SERVER['HTTP_HOST'] , Yii::app()->createAbsoluteUrl('/')) ?> был успешно восстановлен и изменен в целях сохранения конфиденциальности Ваших данных.<br/>
Ваш новый пароль : <?php echo $password ?>
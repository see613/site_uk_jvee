<?php
$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.ActivityLog')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.CREATE'),
);

$this->menu=array(
	array('label' => Yii::t('Bootstrap', 'LIST.ActivityLog'), 'url'=>array('index')),
);

echo '<h1>';
echo Yii::t("Bootstrap", "CREATE.ActivityLog");
echo '</h1>';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
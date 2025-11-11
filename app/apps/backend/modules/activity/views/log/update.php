<?php
$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.ActivityLog')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.UPDATE'),
);

$this->menu=array(
	array('label'=> Yii::t('Bootstrap', 'LIST.ActivityLog'), 'url'=>array('index')),
	array('label'=>	Yii::t('Bootstrap', 'CREATE.ActivityLog'), 'url'=>array('create')),
);

// $model->{$this->tableSchema->primaryKey}
echo '<h1>';
echo Yii::t('Bootstrap', 'UPDATE.ActivityLog');
echo '&nbsp;#'. $model->id;
echo '</h1>';
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
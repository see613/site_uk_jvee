<?php
$this->breadcrumbs=array(
	'Activity Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ActivityLog','url'=>array('index')),
	array('label'=>'Create ActivityLog','url'=>array('create')),
	array('label'=>'Update ActivityLog','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ActivityLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ActivityLog','url'=>array('admin')),
);
?>

<h1>View ActivityLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'activity_id',
		'user_id',
		'family_id',
		'score',
		'created_at',
	),
)); ?>

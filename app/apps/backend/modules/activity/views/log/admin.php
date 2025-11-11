<?php
/*$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.ActivityLog')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.MANAGE'),
);*/

$this->layout = '//layouts/main';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('activity-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<legend><?php echo Yii::t("Bootstrap", "LIST.ActivityLog" ) ?></legend>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.


<?php #echo Yii::t("Bootstrap", "PHRASE.SEARCH_HINT") ?></p></p>-->

<!-- search-form -->

<?php
$assetsDir = Yii::app()->basePath;

$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

	'id'=>'activity-log-grid',

	'dataProvider'=>$model->with(array('user'))->search(),
    'type' => 'bordered striped',
    'enableHistory' => true,

    /*'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),*/

	'filter'=>$model,
	'columns'=>array(
            //'id',
            'name',
            'key',

            /**
            array(
                'name' => 'action_id',
                'type' => 'html',
		        'value' => 'isset($data->action) ? $data->action["title"] : "<i class=\"muted\">".Yii::t("Bootstrap", "PHRASE.NONE")."</i>"',
                'filter' => CHtml::listData(ActivityAction::model()->findAll(),'id','title'),
            ),
            */


            array(
                'name' => 'user_id',
                'type' => 'html',
		        'value' => '$data->user["username"]',
            ),

            'score',
            'created_at',
            'comment',

            /*
                array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'options'=>array(
                        'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                        'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),
             *
             */
	),
)); ?>

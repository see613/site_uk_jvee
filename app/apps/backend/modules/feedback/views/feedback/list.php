
<legend><?php echo Yii::t("Bootstrap", "LIST.Feedback" ) ?></legend>

<?php

$assetsDir = Yii::app()->basePath;
$labels = Feedback::model()->attributeLabels();



$this->widget('backendfilterWidget', array(
    'listId' => 'feedback-grid',
    'model' => $model,
    'columns'=>array(



        array(
            'name',
            'htmlOptions'=>array('class'=>'span5')
        ),
        array(
            'email',
            'htmlOptions'=>array('class'=>'span5')
        ),
        array(
            'phone',
            'htmlOptions'=>array('class'=>'span5')
        ),



    ),
));


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'id'=>'feedback-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

    'dataProvider'=>$model->search(),
    'filter'=>null,
    //'filter'=>$model,
    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

    'columns'=>array(



        array(
            'header'=> $labels["id"],
            'name'=> "id",
        ),


        array(
            'header'=> $labels["name"],
            'name'=> "name",
        ),


        array(
            'header'=> $labels["email"],
            'name'=> "email",
        ),
        array(
            'header'=> $labels["phone"],
            'name'=> "phone",
        ),



        array(
            'header'=> $labels["created_at"],
            'name'=> "created_at",
        ),


        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("feedback/update/id/" . $data->id)',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
    ),
)); ?>

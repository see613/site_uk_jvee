<?php
Yii::import('application.extensions.yii-chosen-master.*');
/**
 * Кастомизированный контроллер backend модулей
 */
class Controller extends CController
{
	public $layout='//layouts/column1';
	public $menu=array();
	public $breadcrumbs=array();
	public $application = 'YiiPack';

	public function init(){

        $this->publishAssets();

        //Yii::app()->clientScript->registerCoreScript('jquery');
        //Yii::app()->clientScript->registerCoreScript('jquery.ui');
	}

    /**
     * Публикация скриптов
     */
    public function publishAssets(){
    
        $url = Yii::app()->assetManager->publish( __DIR__ . '/../assets', false, -1, YII_DEBUG );

        // publish scripts
        $cs = Yii::app()->clientScript; 
        
        // sb-admin
        $cs->registerCssFile($url.'/css/style.css');
        //$cs->registerCssFile($url.'/css/glyphicons.css');
        
    }

    /**
     * Фильтры backend
     */
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

	public function t($phrase, $params = array()){
		return Yii::t( ucfirst($this->module->name) . 'Module.Phrases', $phrase, $params);
	}

    /**
     * Правила доступа к backend
     */
	public function accessRules()
    {
        return array(
            // даем доступ только админам
            array(
                'allow',
                'roles'=>array('admin'),
            ),
            // всем остальным разрешаем посмотреть только на страницу авторизации
            array(
                'allow',
                'actions'=>array('login', 'logout', 'access', 'error'),
                'users'=>array('*'),
            ),
            // запрещаем все остальное
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Дополняем меню до нужного вида
     */
    public function stateUrl($name, $add = array(), $remove = array() ){
        foreach($remove as $item){
            unset($add[$item]);
        }

        return $this->createUrl($name, $add);
    }

    public function itemUrl($name, $id, $add = array(), $remove = array()){
        return $this->stateUrl($name, array('id' => $id) + $add + $_GET, array_merge(array('ajax'), $remove)); //todo array_merge?
    }

    public function listUrl($name, $add = array(), $remove = array()){
        return $this->stateUrl($name, $add + $_GET, array_merge(array('id'), $remove)); //todo array_merge?
    }

    /**
     * Кнопка массового удаления записей
     */
    public function bulkRemoveButton(){
        return array(
            array(
                'id' => 'bulk-remove',
                'buttonType' => 'button',
                'type' => 'primary',
                'size' => 'small',
                'label' => Yii::t('Bootstrap', 'GRID.Remove_selected'),
                'click' => 'js:function(checkBoxes){
					var values = [];
					checkBoxes.each(function () {
						values.push($(this).val());
					});

					$.ajax({
					    url: "' . CHtml::normalizeUrl(array('delete', 'ajax' => 'bulk-remove')) . '",
					    type: "POST",
					    data: {"id":values},
					    success: function(){
					        $(".grid-view").yiiGridView("update");
					    },
					    error: function(jqXHR, textStatus, errorThrown) {
					        if(jqXHR.status && jqXHR.status==500){
					            $(".grid-view").yiiGridView("update");  // некоторые записи могут быть удалены даже в случае ошибки, поэтому всегда будем обновляться
                                alert(jqXHR.responseText);
                           }
					    }
					});
				}',
				'htmlOptions' => array(
					'confirm' => Yii::t('Bootstrap', 'GRID.Remove_selected?'),
				)
            )
        );
    }
}
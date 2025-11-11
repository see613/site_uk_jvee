<?php
/**
 * Кастомный контроллер для frontend режима
 */
class Controller extends CController
{
	public $menu=array();
	public $breadcrumbs=array();
    public $layout = '//layouts/main';
    public $pageTitle = 'Application';

    public $activePage = 'index';
    public $activeSubPage = null;
    public $shareData;


	public function init(){
        //$this->publishAssets();

        //Yii::app()->clientScript->registerCoreScript('jquery');
        //Yii::app()->clientScript->registerCoreScript('jquery.ui');
	}

    protected function beforeAction($event)
    {
        if (!Yii::app()->user->isGuest) {
            //$this->checkProjectData();
        }

        return true;
    }

    public function checkProjectData(){
        $value = Project::getCurrentOne();

        if (empty($value) && Yii::app()->controller->action->id != 'projectsetajax') {
            $model = Project::model()->findByCurrentUser();

            $this->redirect('/project/set/'.$model[0]->id.'?url='.urlencode(Yii::app()->request->getUrl()));
        }
    }

    /**
     * Публикация скриптов
     */
    public function publishAssets(){
    
        $url = Yii::app()->assetManager->publish( __DIR__ . '/../assets', false, -1, YII_DEBUG );

        // publish scripts
        $cs = Yii::app()->clientScript;

        $cs->registerScriptFile($url.'/js/script.js');
        $cs->registerScriptFile($url.'/js/html5.js');
        $cs->registerCssFile($url.'/css/style.css');
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

	public function accessRules(){
        return array(

        );
    }

    /**
     * Загрузка файла на сервер (устаревший метод, сейчас используется EFineUploader)
     *
     * notice: метод get_class заменен на нативный instanceof, а также
     * теперь метод возвращает полное имя файла, если загрузка удалась, иначе false
     */
    public function uploadFile($model, $fieldName, $path = '/uploads/images') {

        $file = CUploadedFile::getInstance($model, $fieldName);

        if (is_object($file) && ($file instanceof CUploadedFile)) {
            $date = date('YmdHms');
            $filename = Yii::app()->basePath . '/../www' . $path . '/' . $date . '_' . $file;
            $file->saveAs($filename);
            $model->$fieldName = $date . '_' . $file;
            return $filename;
        }
        return false;
    }

    /**
     * max nested level is 2
     *
     * @param $params
     * @return array|string
     */
    public function pageUrl($params, $onlyParamString = false) {
        UrlHelper::pageUrl($params, $onlyParamString);
    }

}
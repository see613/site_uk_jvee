<?php

class ListController extends Controller {

	public $defaultAction = 'index';

    public function actionLoadlist(){
        $list = Yii::app()->db->createCommand()
			->select('id, email as text')
			->from(User::model()->tableName())
			->queryAll();
        echo CJSON::encode($list);
    }
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
	public function actionCreate()
	{
		$model=new User('register');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

            if($model->save()){
                if( isset($_POST['go_to_list']) ){
                    $this->redirect( $this->listUrl('index') );
                } else {
                    $this->redirect( $this->itemUrl( 'list/update', $model->id) );
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'update' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

            if($model->save()){

                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);

                $this->redirect( $url );
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * File uploader controller
	 */
	public function actionUpload(){

		$webFolder = '/uploads/user/';
		$tempFolder = Yii::app()->basePath . '/../www' . $webFolder;

		@mkdir($tempFolder, 0777, TRUE);
		@mkdir($tempFolder.'chunks', 0777, TRUE);

		Yii::import("ext.EFineUploader.qqFileUploader");

		$uploader = new qqFileUploader();
		$uploader->allowedExtensions = array('jpg','jpeg', 'png', 'gif');
		$uploader->sizeLimit = 6 * 1024 * 1024;//maximum file size in bytes
		$uploader->chunksFolder = $tempFolder.'chunks';

		$result = $uploader->handleUpload($tempFolder);
		$result['filename'] = $uploader->getUploadName();
		$result['folder'] = $webFolder;

		$uploadedFile=$tempFolder.$result['filename'];

		header("Content-Type: text/plain");
		$result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $result;
		Yii::app()->end();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
		    $id = Yii::app()->request->getParam('id', array());
		    $list = is_array($id) ? $id : array($id);
			foreach($list as $id){
			    $this->loadModel($id)->delete();
            }
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	    }
	}

    /**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new User();
		$model->unsetAttributes();  // clear any default values

        if(isset($_GET['User'])){
            $model->attributes = $_GET['User'];
        }

        $provider=new CActiveDataProvider('User', array(
          'sort'=>array(
            'defaultOrder'=>'id DESC',
          ),
          'Pagination' => array (
            'PageSize' => 5,
           ),
        ));

        $provider->criteria = $model->search();

		$this->render('list',array(
			'model'=>$model,
            'provider'=>$provider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);

		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='User-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class LogController extends Controller
{
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model = new ActivityLog('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['ActivityLog'])){
			$model->attributes=$_GET['ActivityLog'];
        }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
                $this->loadModel($id)->delete();
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ActivityLog::model()->findByPk($id);

		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}

		return $model;
	}
}

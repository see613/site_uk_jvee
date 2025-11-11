<?php

class NewsWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'created_at desc';
        $criteria->limit = 4;

        $model = Blog::model()->findAll($criteria);

        $this->render('news', array(
            'model'=>$model
        ));
    }

}
?>
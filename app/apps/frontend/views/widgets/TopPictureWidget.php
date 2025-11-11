<?php

class TopPictureWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $data = PagesInfoStorage::get();
        $template = count($data)>1 ? 'top-slider' : 'top-picture';

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('/js/top.js?2');


        $this->render($template, array(
            'data'=>$data
        ));
    }

}
?>
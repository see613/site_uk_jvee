<?php


class FeedbackWidget extends CWidget
{
    public $topic = false;
    public $template = 'feedback';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $form = new Feedback('widget');

        $this->render($this->template, array(
            'model'=>$form
        ));
    }
}
?>
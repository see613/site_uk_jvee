<?php

class MetaTagsWidget extends CWidget
{
    public $currentPage;

    public $name = 'JV Electrical Essex Ltd';
    private $tags = array(
        'default'=>'index',

        'index'=>array(
            'title'=>'',
            'description'=>'',
            'keywords'=>''
        ),
        'contact'=>array(
            'title'=>'',
            'description'=>'',
            'keywords'=>''
        ),
    );


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (empty($this->currentPage)) {
            throw new Exception('the current page isn\'t specified');
        }

        if (isset($this->tags[$this->currentPage])) {
            $content = $this->tags[$this->currentPage];
        }
        else {
            $page = $this->tags['default'];
            $content = $this->tags[$page];
        }

        $this->render('meta', array(
            'content'=>$content
        ));
    }

}
?>
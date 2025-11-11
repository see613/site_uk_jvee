<?php

class PagesInfoStorage extends CApplicationComponent {
    public static $instance;
    public static $activePage;
    private $preparedData;
    private $version = '2';

    private $folderPath = '/images/top';
    private $fileExt = 'jpg';
    private $data = array(
        'default'=>'index',

        'index'=>array(
            array(
                'picture'=>'index/1',
                'minHeight'=>300,
                'percentHeight'=>100,
                'valign'=>'middle',
                'headline-1'=>'We Provide Highest Quality',
                'headline-2'=>'BUILDING SERVICES',
                'description'=>'The Professional team you can depend on'
            ),
            array(
                'picture'=>'index/1',
                'minHeight'=>300,
                'percentHeight'=>100,
                'valign'=>'middle',
                'headline-1'=>'We Provide Highest Quality',
                'headline-2'=>'BUILDING SERVICES',
                'description'=>'The Professional team you can depend on'
            )
        ),
    );


    public function getData(){
        if(empty($this->preparedData)){
            $this->preparedData = $this->prepareData();
        }
        return $this->preparedData;
    }

    private function prepareData(){
        $result = array();

        if (empty(self::$activePage)) {
            throw new Exception('the active page isn\'t specified');
        }

        if (isset($this->data[self::$activePage])) {
            $data = $this->data[self::$activePage];
        }
        else {
            // get data for the default page
            $page = $this->data['default'];
            $data = $this->data[$page];
        }

        if (!is_array($data)) {
            $data = array($data);
        }

        foreach ($data as $item) {
            if (!is_array($item)) {
                $item = array('picture'=>$item);
            }
            if(!empty($item['picture'])){
                $item['picture'] = $this->folderPath.'/'.$item['picture'].'.'.$this->fileExt.'?'.$this->version;
            }
            $result[] = $item;
        }
        return $result;
    }


    public static function get(){
        if(empty(self::$instance)){
            self::$instance = new PagesInfoStorage();
        }
        return self::$instance->getData();
    }

    public static function initiate($activePage){
        self::$activePage = $activePage;
    }

    public static function getBodyClass(){
        $classes = array(
            //'contact'=>'contact-body',
        );

        return !empty($classes[self::$activePage]) ? $classes[self::$activePage] : '';
    }

}


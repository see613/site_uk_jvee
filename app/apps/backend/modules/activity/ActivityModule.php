<?php

class ActivityModule extends Module
{
    public $defaultController = 'log';

	public function init(){
		$this->setImport(array(
			'activity.models.*',
		));
	}

	public function beforeControllerAction($controller, $action){
		return parent::beforeControllerAction($controller, $action) ? true : false;
	}
}

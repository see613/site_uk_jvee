<?php

class UserWebUser extends CWebUser {

    public $allowAutoLogin = false;

	private $states = array();
	private $_model = null;

	public function init(){
		parent::init();
	}

	public function getRole() {
		if($user = $this->getModel()){
            return $user->role_id;
        }
	}

	public function getModel() {
        if (!$this->isGuest && empty($this->_model)){
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
	}

	public function getReturnUrl1() {
		if ($this->role == 'client') {
			return '/';
		}
		else {
			return '/admin';
		}
	}
}
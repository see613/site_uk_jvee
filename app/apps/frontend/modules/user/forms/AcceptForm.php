<?php

class AcceptForm extends CFormModel {

    public $code;
    public $user_code;

    public function rules() {
        return array(
            array('code, user_code', 'required', 'message' => 'Не заполнено поле "{attribute}"'),
            array('code', 'checkCode', 'message' => 'Некорректный код активации')
        );
    }

    /**
     * Проверяем уникальность email пользователя
     */
    public function checkCode($field, $data) {
        if (!$this->getError($field)) {

            echo $this->user_code;


            if ( $this->$field != $this->user_code ) {
                $this->addError($field, $data['message']);
            }
        }
    }

    public function attributeLabels() {
        return array(
            'code' => 'Код',
        );
    }
}
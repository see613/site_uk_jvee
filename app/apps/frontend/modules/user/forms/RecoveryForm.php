<?php

class RecoveryForm extends CFormModel {

    public $email;

    public $captcha;
    public $userModel;

    public $recovery_time;

    public $check_string;

    public function rules() {

        $rules = array(
            array('captcha', 'captcha', 'captchaAction'=>'/user/registration/captcha_recovery'),

            // валидация email
            array('email', 'required', 'on' => 'checkEmail'),
            array('email', 'email', 'checkMX'=>true, 'on' => 'checkEmail'),
            array('email', 'length', 'max'=>254, 'on' => 'checkEmail'),
            array('email', 'checkExists', 'message' => 'Такой email в системе не найден', 'on' => 'checkEmail'),

            // валидация телефона
            array('email', 'length', 'max' => 16, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'значение не должно превышать {max} символов', 'tooShort' => 'значение не должно быть меньше {min} символов', 'on' => 'checkPhone'),
            array('email', 'match', 'pattern' => '~^\+7\(\d\d\d\)\d\d\d\-\d\d\-\d\d$~', 'message' => 'Номер должен соответствовать формату "+7(XXX)ХХХ-ХХ-ХХ", например "+7(910)123-45-67"', 'on' => 'checkPhone'),
            array('email', 'checkExistsPhone', 'message' => 'Такой номер в системе не найден', 'on' => 'checkPhone'),

            array('recovery_time', 'checkTime', 'lockTime' => 6, 'message' => 'Вы только что восстановили пароль, он Вам уже отправлен.'),
        );

        return $rules;
    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('Models', 'USER.EMAIL'),
            'captcha' => Yii::t('Models', 'FULL_REGISTER_MODEL.CAPTCHA'),
        );
    }

    public function checkTime($name, $data){

        if (!$this->hasErrors()) {

            // время блокировки (в секундах)
            $lockTime = $data['lockTime'];

            // прошло секунд
            $last = time() - strtotime($this->userModel->recovery_password_at);

            //echo $lockTime . ' ' . $last;die;

            if( $last < $lockTime ){
                $this->addError('email', $data['message'] );
            }

        }
    }

    public function checkExists($name, $data) {
        if (!$this->hasErrors($name)) {

            $this->userModel = User::model()->find( $name . '=:value', array(':value'=>$this->$name));

            if (empty($this->userModel)) {
                $this->addError($name, $data['message'] );
            }
        }
    }

    public function checkExistsPhone($name, $data) {
        if (!$this->hasErrors($name)) {

            $value = str_replace( array('(', ')', '-'), '', $this->$name );
            $this->userModel = User::model()->find( 'phone=:value', array(':value'=>$value));

            if (empty($this->userModel)) {
                $this->addError($name, $data['message'] );
            }
        }
    }

    public function getUser(){
        return $this->userModel;
    }
}
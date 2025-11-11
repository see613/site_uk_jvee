<?php

class SubscribeForm extends CFormModel {

	public $email;
	public $first_name;
    public $accept_process;
	public $captcha;

	public function rules() {
		return array(
			array('email, first_name', 'required', 'message'=>'Не заполнено поле "{attribute}"'),
            array('email', 'email', 'checkMX'=>true, 'message'=>'"{attribute}" не является верным адресом электронной почты'),
			array('email', 'length', 'max'=>254, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'значение не должно превышать {max} символов', 'tooShort'=>'значение не должно быть меньше {min} символов'),
            array('first_name', 'match', 'pattern'=>'/^[a-zа-я]{2,}$/ui', 'message'=>'Поле "{attribute}" заполнено неправильно'),
			array('first_name', 'length', 'max'=>128, 'message'=>'"{attribute}" заполнено неверно', 'tooLong'=>'значение не должно превышать {max} символов', 'tooShort'=>'значение не должно быть меньше {min} символов'),
			array('accept_process', 'compare', 'compareValue'=>true, 'message'=>'Вы не подтвердили согласие на обработку и хранение своих персональных данных и получения новостей от сайта johnsonsbaby.ru'),
			array('captcha', 'captcha', 'captchaAction'=>'captcha_subscribe', 'message'=>'Неправильный код проверки'),
            array('email', 'checkEmail'),
		);
	}

	protected function afterValidate() {
		return true;
	}

    public function checkEmail() {
        if (!$this->hasErrors()) {
            $model = JUser::model()->find('email=?', array($this->email));
            if (!empty($model)) {
                $this->addError('email', Yii::t('Models', 'Такой email уже существует в системе'));
            }
        }
    }

	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('Models', 'JUSER.EMAIL'),
			'first_name' => Yii::t('Models', 'JUSER.FIRST_NAME'),
			'captcha' => Yii::t('Models', 'FULL_REGISTER_MODEL.CAPTCHA'),
			'accept_process' => Yii::t('Models', 'FULL_REGISTER_MODEL.ACCEPT_PROCCESS'),
		);
	}

}
<?php

class Feedback extends CActiveRecord
{
	public $created_at_start;
	public $created_at_end;
	public $captcha;

	public function rules()
	{
		return array(
            array('name, phone, email, message', 'required', 'on'=>'send, send-check'),
            array('name, email', 'required', 'on'=>'widget, widget-check'),

            array('name, email, phone', 'length', 'max'=>255),
            array('email', 'email'),
            array('captcha', 'ReCaptchaValidator', 'privateKey'=>RECAPTCHA_PRIVATE_KEY, 'on'=>'widget,send'),

            array('name, phone, email, message', 'safe'),

            array('id, name, email, phone, message, created_at, created_at_start, created_at_end', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
				'phone' => 'Telephone Number',
                'message' => 'Message',
				'created_at' => 'Created At',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
        $criteria->compare('message',$this->message,true);
		$this->compareDate($criteria, 'created_at');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort'=>array(
						'defaultOrder'=>'t.id desc'
				)
		));
	}

	public function tableName()
	{
		return '{{feedback}}';
	}

	public function relations()
	{
		return array();
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}

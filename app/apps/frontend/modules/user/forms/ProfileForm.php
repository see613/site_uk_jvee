<?php

class ProfileForm extends CFormModel {

    // Profile data
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $middle_name;

    public $birthday;
    public $birthday_day;
    public $birthday_month;
    public $birthday_year;

    public $sex;
    public $phone;

    // Password
    public $password;
    public $password_repeat;

    // Address
    public $city_id;

    public $address_index;

    public $address_street;
    public $address_street_type;

    public $address_house;
    public $address_poss;
    public $address_corp;
    public $address_building;
    public $address_apart;

    public function rules() {

        return array(

            array('email, birthday, first_name, last_name, phone, sex', 'required', 'message' => 'Не заполнено поле "{attribute}"'),
            array('email', 'email', 'checkMX' => true, 'message' => '"{attribute}" не является верным адресом электронной почты.'),
            array('city_id', 'numerical', 'integerOnly' => true, 'min' => 1, 'allowEmpty' => true, 'message' => '', 'tooSmall' => 'В поле "{attribute}" указан несуществующий населенный пункт'),

            array('birthday', 'date', 'format' => 'yyyy-MM-dd', 'message' => '"{attribute}" содержит неверное значение даты. Укажите дату, соответствующую формату "ДД.ММ.ГГГГ"'),
            array('birthday_day, birthday_month, birthday_year', 'numerical', 'integerOnly' => true, 'allowEmpty' => true),
            array('birthday', 'checkAdult', 'message' => 'Регистрация на сайте разрешена только потребителям, достигшим возраста 18 лет'),

            array('first_name, last_name, middle_name', 'match', 'pattern' => '/[А-Яа-я\-\s]+/', 'message'=>'Поле "{attribute}" должно содержать только русские буквы, пробел, знак тире.'),
            array('last_name, first_name, middle_name', 'length', 'max' => 128, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'значение не должно превышать {max} символов', 'tooShort' => 'значение не должно быть меньше {min} символов'),
            array('last_name, first_name, middle_name', 'match', 'pattern' => '/^[a-zа-я]{2,}$/ui', 'message' => 'Поле "{attribute}" заполнено неправильно'),

            array('email', 'length', 'max' => 254, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'значение не должно превышать {max} символов', 'tooShort' => 'значение не должно быть меньше {min} символов'),
            array('email', 'checkUnique', 'message' => 'Такой email уже существует в системе'),

            array('sex', 'in', 'range' => array(1,2), 'allowEmpty' => false),

            // address
            //array( 'address_index, address_street', 'required', 'message' => 'Не заполнено поле "{attribute}"' ),
            //array( 'address_apart, address_building, address_corp, address_poss, address_house', 'safe' ),
            //array( 'address_poss', 'required', 'message' => 'Не заполнено поле "{attribute}"', 'on' => 'SelectPoss' ),
            //array( 'address_house', 'required', 'message' => 'Не заполнено поле "{attribute}"', 'on' => 'SelectHouse' ),
            //array( 'address_index', 'match', 'pattern' => '~^\d{6}$~', 'message' => 'Указан некорректный индекс'),

            array('phone', 'length', 'max'=>16),
            array('phone', 'match', 'pattern' => '~^\+7[0-9]{10}$~', 'message' => 'Номер должен соответствовать формату "+7XXXXXXXXXX", например "+71234567890"'),
            array('phone', 'checkExistsPhone', 'message' => 'Такой телефон уже существует в системе, воспользуйтесь <a class="open_recovery_popup" href="/profile/forgot">восcтановлением пароля</a> или обратитесь в <a href="/feedback">службу поддержки</a>'),

            array('password', 'length', 'min' => 6, 'max' => 64, 'message' => '"{attribute}" заполнено неверно', 'tooLong' => 'Пароль должен быть не более {max} символов', 'tooShort' => 'Пароль должен быть не менее {min} символов'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Пожалуйста, повторите указанный пароль в "{attribute}" верно.'),
        );
    }

    /**
     * Проверяем возраст потребителя
     */
    public function checkAdult($field, $data) {
        if (!$this->getError($field)) {
            $interval = date_diff(date_create(), date_create($this->birthday) );
            if ( $interval->format("%y") < 18 ) {
                $this->addError($field, $data['message']);
            }
        }
    }

    /**
     * Проверяем существование телефона в бд
     */
    public function checkExistsPhone($name, $data) {
        if (!$this->hasErrors($name)) {

            $value = str_replace( '+', '', $this->$name );
            $model = User::model()->find( 'phone=:value', array(':value'=>$value));

            if (!empty($model) && $model->id != Yii::app()->user->id ) {
                $this->addError($name, $data['message'] );
            }
        }
    }

    /**
     * Проверяем уникальность email пользователя
     */
    public function checkUnique($field, $data) {
        if (!$this->getError($field)) {

            $model = User::model()->find( $field . '=?', array($this->$field));

            if ( $model && $model->id != Yii::app()->user->id ) {
                $this->addError($field, $data['message']);
            }
        }
    }

    /**
     * Обработка полей birthday
     */
    public function setAttributes($values, $safeOnly = true){
        parent::setAttributes($values, $safeOnly);
        if( !empty($this->birthday) && !$this->birthday_day && !$this->birthday_month && !$this->birthday_year ){
            $birthday = strtotime( $this->birthday );
            $this->birthday_day = date('j', $birthday);
            $this->birthday_month = date('n', $birthday);
            $this->birthday_year = date('Y', $birthday);
        }
    }

    public function beforeValidate(){
        $this->birthday = sprintf('%04d-%02d-%02d', $this->birthday_year, $this->birthday_month, $this->birthday_day);
        return parent::beforeValidate();
    }
    //

    public function attributeLabels() {
        return array(
            'email' => Yii::t('Models', 'USER.EMAIL'),
            'birthday' => Yii::t('Models', 'USER.BIRTHDAY'),
            'password' => Yii::t('Models', 'USER.PASSWORD'),
            'password_repeat' => Yii::t('Models', 'USER.PASSWORD_REPEAT'),
            'first_name' => Yii::t('Models', 'USER.FIRST_NAME'),
            'last_name' => Yii::t('Models', 'USER.LAST_NAME'),
            'middle_name' => Yii::t('Models', 'USER.MIDDLE_NAME'),
            'sex' => Yii::t('Models', 'USER.SEX'),
            'city_id' => Yii::t('Models', 'USER.CITY'),
            'country' => Yii::t('Models', 'USER.COUNTRY'),
            'phone' => Yii::t('Models', 'USER.PHONE'),

            'address_index' => 'Индекс',
            'address_street' => 'Улица',
            'address_street_type' => 'Тип улицы',
            'address_house' => 'Дом',
            'address_poss' => 'Владение',
            'profile_info' => 'Дополнительная информация',
        );
    }

}

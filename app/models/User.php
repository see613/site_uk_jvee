<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $role_id
 * @property integer $score
 * @property string $email_accept_code
 * @property string $email_accept_time
 * @property integer $subscribe;
 * @property integer $state

 * @property string $recovery_code
 * @property string $recovery_password_at;

 * @property string $birthday;
 * @property string $created_at;
 * @property string $last_login

 * @property string $email
 * @property string $username
 * @property string $last_name
 * @property string $middle_name
 * @property string $first_name

 * @property string $password
 * @property string $profile_info

 *
 * The followings are the available model relations:
 * @property City $city
 */
class User extends CActiveRecord {

    const STATE_NEW = 0;
    const STATE_ACTIVE = 1;
    const STATE_BLOCKED = 2;

    public $password_repeat;
    private $_oldPassword;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(){

        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('email', 'required'),
            array('email', 'unique'),
            array('email', 'length', 'max' => 254),

            array('password_repeat, password', 'required', 'on' => 'register'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password'),
            array('password', 'length', 'max' => 64),

            //array('city_id', 'numerical', 'integerOnly' => true, 'allowEmpty' => true),

            array('state, is_subscribe', 'boolean'),
            array('username', 'length', 'max' => 254),

            array('last_name, first_name, middle_name', 'length', 'max' => 128),
            array('role_id, sex, profile_info, birthday, score, id, created_at, company_name, company_logo_file', 'safe' ),

            //array( 'address_index, address_street, address_street_type', 'safe' ),
            //array( 'address_apart, address_building, address_corp, address_poss, address_house', 'safe' ),

            //array( 'address_poss', 'required', 'message' => 'Не заполнено поле "{attribute}"', 'on' => 'SelectPoss' ),
            //array( 'address_house', 'required', 'message' => 'Не заполнено поле "{attribute}"', 'on' => 'SelectHouse' ),

            //array('address_index', 'required'),

            //array('full_address', 'length', 'max'=>1000),
            //array('mail_street', 'length', 'max' => 64),
            //array('mail_street_house, mail_street_corps, mail_street_apartment', 'length', 'max' => 15),

            array('phone', 'length', 'max' => 16),
            // array('logins, last_login', 'length', 'max'=>10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, username, created_at, state, is_subscribe, score, birthday, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
            'id' => 'ID',
            'code_enter_failed' => Yii::t('Models', 'USER.CODE_ENTER_FAILED'),
            'email' => Yii::t('Models', 'USER.EMAIL'),
            'username' => Yii::t('Models', 'USER.USERNAME'),
            'password' => Yii::t('Models', 'USER.PASSWORD'),
            'password_repeat' => Yii::t('Models', 'USER.PASSWORD_REPEAT'),
            'last_name' => Yii::t('Models', 'USER.LAST_NAME'),
            'first_name' => Yii::t('Models', 'USER.FIRST_NAME'),
            'birthday' => Yii::t('Models', 'USER.BIRTHDAY'),
            'sex' => Yii::t('Models', 'USER.SEX'),
            //'city_id' => Yii::t('Models', 'USER.CITY'),
            'phone' => Yii::t('Models', 'USER.PHONE'),
            'mail_confirm' => Yii::t('Models', 'USER.MAIL_CONFIRM'),
            'logins' => Yii::t('Models', 'USER.LOGINS'),
            'last_login' => Yii::t('Models', 'USER.LAST_LOGIN'),
            'created_at' => Yii::t('Models', 'USER.CREATED'),
            'state' => 'State',
            'is_subscribe' => Yii::t('Models', 'USER.SUBSCRIBE'),
            'blocked' => Yii::t('Models', 'USER.BLOCKED'),
            'role_id' => 'Role',

            //new
            //'mail_index' => Yii::t('Models', 'USER.MAIL_INDEX'),
            //'mail_street' => Yii::t('Models', 'USER.MAIL_STREET'),
            'country' => Yii::t('Models', 'USER.COUNTRY'),
            //'mail_street_house' => Yii::t('Models', 'USER.MAIL_STREET_HOUSE'),
            //'mail_street_corps' => Yii::t('Models', 'USER.MAIL_STREET_CORPS'),
            //'mail_street_apartment' => Yii::t('Models', 'USER.MAIL_STREET_APARTMENT'),
        );
    }

    public function getState($value){
        $list = $this->getStateList();
        return $list[$value];
    }

    public function getStateList(){
        return array(
            self::STATE_NEW => 'new',
            self::STATE_ACTIVE => 'activated',
            self::STATE_BLOCKED => 'blocked',
        );
    }

    public function scopes() {
        return array(
            'subscribed' => array(
                'condition' => 'is_subscribe > 0 AND is_subscribe IS NOT NULL'
            )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {

        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        //compare roles
        //$criteria->with = array('role');
        $criteria->together = true;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('is_subscribe', $this['is_subscribe'], true);
        $criteria->compare('role_id', $this->role_id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('score', $this->score);
        $criteria->compare('birthday',strtotime($this['birthday'] ?? ''),true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('state', $this->state);

        return $criteria;
    }

    /**
     * Метод updateSecurity
     * Обновляет activation_code и token_time
     * notice: Заменяет метод updateActivationCode в контроллере Register
     */
    public function updateSecurity() {
        $this['email_accept_code'] = md5(uniqid());
        $this['email_accept_time'] = new CDbExpression('NOW()');
    }

    /**
     * Генерирует случайный пароль
     */
    public function setRandPassword() {
        $password = Yii::app()->helper->random(6, '0123456789');
        $this['password'] = $password;
        //$this['password'] = md5($password);
        return $password;
    }

    protected function afterFind() {

        parent::afterFind();

        $this->_oldPassword = $this->password;

        if( !empty($this->phone) ){
            $this->phone = '+' . $this->phone;
        }
    }

    protected function beforeSave() {

        if(parent::beforeSave()) {

            // приводим телефон к нужному формату
            $this->phone = str_replace('+', '', $this->phone );

            // Возвращаем старый пароль, если поле с паролем не задано
            if( empty($this->password) ){
                $this->password = $this->_oldPassword;
            }

            if( strcmp( $this->_oldPassword, $this->password ) !== 0){
                $this->password = md5($this->password);
            }

            // преобразуем формат даты
            if( preg_match('~^(\d\d)\.(\d\d)\.(\d\d\d\d)$~', $this->birthday, $match) ){
                $this->birthday = sprintf('%04d-%02d-%02d 00:00:00', $match[3], $match[2], $match[1]);
            }

            return true;
        }

        return false;
     }

    /**
     * Устанавливаем роль пользователя (роли задаются в /apps/config/auth.php)
     */
    public function setRole($id){

        $roles = $this->getRoles();

        if( !isset($roles[$id]) ){
            throw new Exception('Set incorrect role id "' . $id . '"');
        }

        $this->role_id = $id;
        return $roles[$id];
    }

    /**
     * Извлекаем описание роли
     */
    public function getRole($id){
        $roles = $this->getRoles();
        return $roles[$id];
    }

    /**
     * Извлекаем полный список ролей
     */
    public function getRoles(){

        $fullList = Yii::app()->authManager->getRoles();
        $list = array();

        foreach($fullList as $item){
            $name = $item->getName();

            if( $name != 'guest' ){
                $list[$name] = $item->getDescription();
            }
        }

        return $list;
    }

    public function getStreetTypes($index = null){

        $list = array(
            1 => 'Переулок',
            2 => 'Проспект',
            3 => 'Тупик',
            4 => 'Улица',
            5 => 'Шоссе',
        );

        return $index ? $list[$index] : $list;
    }

    public function addScore($value){
        $this->score += $value;
        $this->save();
    }


    public function getCompanyLogo(){
        return '/uploads/user/'.$this->company_logo_file;
    }

}

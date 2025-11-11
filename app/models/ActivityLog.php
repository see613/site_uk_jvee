<?php

/**
 * This is the model class for table "{{activity_log}}".
 *
 * The followings are the available columns in table '{{activity_log}}':
 * @property string $id
 * @property string $name
 * @property string $key
 * @property string $comment
 * @property string $user_id
 * @property string $score
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Activity $activity
 * @property Juser $user
 */
class ActivityLog extends CActiveRecord
{
    public $user_name;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActivityLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{activity_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, user_id', 'required'),
			array('user_id, score', 'length', 'max'=>11),
			array('created_at, comment', 'safe'),
			array('id, name, key, user_id, score, created_at, user_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '№',
			'name' => 'Имя действия',
			'user_id' => 'Пользователь',
			'score' => 'Баллов',
			'key' => 'Ключ',
			'comment' => 'Комментарий',
			'created_at' => 'Создан',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with = array('user');

		//$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('user.username',$this->user_id,true);
		$criteria->compare('t.score',$this->score,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'user_id'=>array(
                        'asc'=>'user.username ASC',
                        'desc'=>'user.username DESC',
                    ),
                    '*',
                ),
                'defaultOrder'=>'t.id DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}

}
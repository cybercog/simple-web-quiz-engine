<?php

/**
 * This is the model class for table "tbl_participant".
 *
 * The followings are the available columns in table 'tbl_participant':
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property integer $session_id
 *
 * The followings are the available model relations:
 * @property Session $session
 */
class Participant extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Participant the static model class
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
		return 'tbl_participant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('session_id', 'numerical', 'integerOnly'=>true),
			array('email, last_name', 'length', 'max'=>100),
			array('first_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email, first_name, last_name, session_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'session_id' => 'Session',
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

		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('session_id',$this->session_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
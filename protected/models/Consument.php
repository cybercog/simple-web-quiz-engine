<?php

/**
 * This is the model class for table "tbl_consument".
 *
 * The followings are the available columns in table 'tbl_consument':
 * @property integer $max_value
 * @property string $description
 * @property string $layout
 */
class Consument extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Consument the static model class
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
		return 'tbl_consument';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, layout', 'required'),
			array('layout', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('max_value, description, layout', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'max_value' => 'Max Value',
			'description' => 'Description',
			'layout' => 'Layout',
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

		$criteria->compare('max_value',$this->max_value);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('layout',$this->layout,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
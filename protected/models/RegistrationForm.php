<?php

class RegistrationForm extends CFormModel {
	
	public $email;
	public $firstName;
	public $lastName;
	
	public $verifyCode;
	
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'uniqueEmail'),
			array('firstName', 'length', 'min'=>3, 'max'=>30),
			array('lastName', 'length', 'min'=>3, 'max'=>50),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Adres email',
			'firstName'=>'Imię',
			'lastName'=>'Nazwisko',
			'verifyCode'=>'Kod weryfikacyjny',
		
		);
	}
	
 	public function uniqueEmail($attribute,$params) {
 		if (Participant::model()->findByPk($this->email) != null) {
 			$this->addError('email', "Podany adres email jest już zarejestrowany!");
 		}
    }
	
	
	
}
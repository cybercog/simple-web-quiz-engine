<?php

class Result extends CFormModel
{
	public $answer;
	public $value;
	
    public function rules()
    {
        return array(
            array('answer', 'required'),
        );
    }
    
/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'answer' => 'Odpowiedź',
			'value' => 'Wartość',
		);
	}
 
}
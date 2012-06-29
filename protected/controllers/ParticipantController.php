<?php

class ParticipantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('register', 'captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'index', 'view'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Participant;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Participant']))
		{
			$model->attributes=$_POST['Participant'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->email));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Participant']))
		{
			$model->attributes=$_POST['Participant'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->email));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Participant');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Participant('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Participant']))
			$model->attributes=$_GET['Participant'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionRegister()
	{
		// check the session
		if (!isset($_GET['id'])) {
			$this->onWrongSession();
		}
		
		$session = Session::model()->findByPk($_GET['id']);
		if ($session == null || $session->state != 'finished') {
			$this->onWrongSession();
		}
		
		
		$model = new RegistrationForm();
		// collect user input data
		if(isset($_POST['RegistrationForm']))
		{
			$model->attributes=$_POST['RegistrationForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()) {
				$participant = new Participant();
				$participant->email = $model->email;
				$participant->first_name = $model->firstName;
				$participant->last_name = $model->lastName;
				$participant->session_id = $session->id;
				$participant->save();
				$session->state = 'registered';
				$session->save();
				Yii::app()->user->setFlash('contact','Dziękujemy za wzięcie udziału w quizie.');
			}
			
		}
		$consument = $this->computeConsumentType($session);
		$this->layout = $consument->layout;
		$this->render('register', array('model'=>$model, 'session'=>$session, 'consument'=>$consument));
		
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Participant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='participant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function onWrongSession() {
		// no idea why the raw controller/action notation does not work 
		$this->redirect('index.php?r=question/index');
	}
	
	private function computeConsumentType($session) {
		$totalPoints = intval($session->result);
		// get all cosuments sorted by theirs max value
		$criteria=new CDbCriteria;
		$criteria->order = 'max_value ASC';
		$consuments = Consument::model()->findAll($criteria);
		foreach ($consuments as $consument) {
			if ($totalPoints < intval($consument->max_value)) {
				return $consument;
			}
		}
				
	}
}

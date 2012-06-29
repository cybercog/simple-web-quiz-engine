<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function beforeAction($action) {
		$criteria=new CDbCriteria;
		$criteria->select='id'; 
		$criteria->order='id';
		$questions = Question::model()->findAll($criteria);
		$steps = array();
		$i = 0;
		foreach ($questions as $question) {
			$steps[$i++] = $question->id;
		}
		
		$config = array ();
		if ($action->id == 'index') {
			$config = array ('steps' => $steps, 
			'continueOnExpired' => true, 
			'forwardOnly' => true,
			//'timeout'=> 30, 
			'events' => array (
				'onStart' => 'wizardStart', 
				'onProcessStep' => 'quizProcessStep', 
				'onFinished' => 'quizFinished', 
				'onInvalidStep' => 'quizInvalidStep', 
				'onExpiredStep' => 'quizExpiredStep' ) );
		}
		
		if (! empty ( $config )) {
			$config ['class'] = 'application.components.WizardBehavior';
			$this->attachBehavior('wizard', $config );
		}
		return parent::beforeAction ( $action );
	}
	
	
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'view', 'list'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex($step = null) {
		$this->pageTitle = 'Quiz Wizard';
		$this->process ( $step );
	}
	
	
	public function wizardStart($event) {
		$event->handled = true;
	}
	
	/**
	 * Process steps from the quiz
	 * @param WizardEvent The event
	 */
	public function quizProcessStep($event) {
		$question = Question::model()->with('answers')->findByPk($event->step);
		if (empty($question->answers)) {
			$this->handleEmptyQuestion($event, $question);
		} else {
			$this->handleQuestionWithAnswers($event, $question);
		}
		
	}
	
	private function handleEmptyQuestion($event, $question) {
		$result = new Result();
		$form = new CForm(array(
			'title'=>$question->content,	
			'buttons'=>array(
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Następne'
				)
			)
		), $result);
		if ($form->submitted('submit', false)) {
			$event->sender->save(array('result'=>$result));
			$event->handled = true;
		} else {
			$this->layout = $question->category;
			$this->render ( 'quiz/form', compact ( 'event', 'question', 'form' ) );
		}
	}
	
	private function handleQuestionWithAnswers($event, $question) {
		$result = new Result();
		$items = array();
		foreach ($question->answers as $answer) {
			$items[$answer->id] = $answer->answer; 
		}
		$form = new CForm(array(
			'title'=>$question->content,	
			'elements'=>array(
				'answer'=>array(
					'type'=>'radiolist',
					'items'=>$items,
					'prompt'=>$question->content,
					'layout'=>'{label}</br>{input}<br/>{error}'
				),
			),
			'buttons'=>array(
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Następne'
				)
			),
			'showErrorSummary'=>false
		), $result);
		if ($form->submitted() && $form->validate()) {
			$event->sender->save(array('result_data'=>$result));
			$event->handled = true;
		} else {
			$this->layout = $question->category;
			$this->render ( 'quiz/form', compact ( 'event', 'question', 'form' ) );
		}
	}
	
	/**
	 * The quiz
	 * @param WizardEvent The event
	 */
	public function quizFinished($event) {
		$results = array();
		$totalPoints = 0;
		foreach ($event->data as $step=>$data) {
			if (array_key_exists('result_data', $data)) {
				$result = $data['result_data'];
				$answer = Answer::model()->findByPk($result->answer);
				if ($answer != null) {
					$totalPoints = $totalPoints + $answer->value;
				}
			}
		}
		$session = new Session();
		$session->time = new CDbExpression('current_timestamp');
		$session->result = $totalPoints;
		$session->state = 'finished';
		$session->save();
		
		$event->sender->reset();
		// Yii::app ()->end();
		
		$this->redirect(array('participant/register', 'id'=>$session->id));
		
	}
	
	/**
	 * Raised when a step has expired.
	 * @param WizardEvent The event
	 */
	public function quizExpiredStep($event) {
		$event->sender->save ( array ('answer' => '<slow>' ) );
	}
	
	/**
	* Raised when the wizard detects an invalid step
	* @param WizardEvent The event
	*/
	public function quizInvalidStep($event) {
		Yii::app()->getUser()->setFlash('notice', $event->step.' is not a vaild step in this wizard');
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
		$model=new Question;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
		));
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function createAndStoreSession() {
		$session = new Session();
		$session = uniqid();
		$session->time = new CDbExpression('NOW()');
		$session->save();
		return $session;
	}
	
}

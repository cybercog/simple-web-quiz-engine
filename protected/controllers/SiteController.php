<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends Controller
{
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$page = null;
		if (isset($_GET['pg']) and is_numeric($_GET['pg'])) {
			$pg = intval($_GET['pg']);
			$page = StaticPage::model()->findByPk($pg);			
		}
		if ($page == null) {
			$page = $this->getDefaultPage();
		}
		$this->render('index', array('page'=>$page));
	}
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionGuide()
	{
		$this->render('guide');
	}
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionLinks()
	{
		$this->render('links');
	}
	
/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	private function getDefaultPage() {
		return StaticPage::model()->findByPk(1);
	}
}
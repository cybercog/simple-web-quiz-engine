<?php

// include Yii bootstrap file
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require_once($yii);
// create a Web application instance and run
Yii::createWebApplication($config)->run();

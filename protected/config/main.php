<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'TEG 2011',

	'theme'=>'teg',

	'language'=>'pl',

	'import'=>array(
		'application.models.*',
		'application.components.*',
    ),

	'components'=>array(
        'db'=>array(
            'class'=>'system.db.CDbConnection',
            'connectionString'=>'sqlite:protected/data/teg.sqlite',
            // turn on schema caching to improve performance
            // 'schemaCachingDuration'=>3600,
        ),
    ),
    
    
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'abc123',
        ),
    ),
);
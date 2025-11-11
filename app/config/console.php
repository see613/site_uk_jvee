<?php

require_once( __DIR__ . '/settings.php' );

Yii::setPathOfAlias('composer', realpath( __DIR__.'/../../composer/vendor' ) );

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
    'preload'=>array('log'),

    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    'aliases'=> array(
        'back' => 'application.apps.backend',
        'front' => 'application.apps.frontend',
    ),

	// application components
	'components'=>array(

        # Настройки базы данных
		'db'=>array(

			'connectionString' => 'mysql:host=' . DB_HOST . ';dbname=' . DB_DBNAME,
			'username' => DB_USERNAME,
			'password' => DB_PASSWORD,

			'tablePrefix' => 'tbl_',
			'charset' => 'utf8',

			// perfomance
			'emulatePrepare' => false,
			'autoConnect' => false,
		    'schemaCachingDuration' => DB_SCHEME_CACHETIME,
            'enableProfiling'=> DEBUG_PANEL ? true : false,
            'enableParamLogging'=> DEBUG_PANEL ? true : false,
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);

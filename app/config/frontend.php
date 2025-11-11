<?php

return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),

    array(

        //'preload' => array('bootstrap'),

        'viewPath' => __DIR__ . '/../apps/frontend/views',
        'modulePath' => __DIR__ . '/../apps/frontend/modules',

	    'import'=>array(
		    'application.apps.frontend.components.*',
		    'application.extensions.*',
            'application.components.MailService.*',
        ),


       /*'controllerMap'=>array(
            'min'=>array(
                'class'=>'ext.minScript.controllers.ExtMinScriptController',
            ),
        ),*/


        // компоненты
        'components'=>array(
            'errorHandler'=>array(
                'errorAction' => 'content/default/error'
            ),

            // пользователь
            'user'=>array(
                'allowAutoLogin' => true,
                'loginUrl'=>array('/login'),
            ),

            // Добавляем jquery нужной версии
            // Для добавления скриптов используем следующий код в общем контроллере (лейауте)
            // Yii::app()->clientScript->registerCoreScript('jquery.ui')
            'clientScript'=>array(
            
                // Скрипт автоминификации (рекомендуется раскоментировать на продакшене)
                // минифицирует только скрипты assets публикации ()

			    //'class'=>'ext.minScript.components.ExtMinScript',
          
                'packages'=>array(
                    'jquery'=>array(
                        'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1.11.3/',
                        'js'=>array('jquery.min.js'),
                    ),
                    'jquery.ui'=>array(
                        'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/',
                        'js'=>array('jquery-ui.min.js'),
                    ),
                    'redactor' => array(
                        'baseUrl' => '/app/extensions/yiibooster/assets/redactor',
                        'js' => 'redactor.min.js',
                        'css' => array('redactor.css'),
                        'depends' => array('jquery')
                    ),
                ),

                'coreScriptPosition'=>CClientScript::POS_END,
                'defaultScriptPosition'=>CClientScript::POS_END,
                'defaultScriptFilePosition'=>CClientScript::POS_END,


                //'minScriptDisableMin'=>array('/(?:js|css)$/i'),
                //'minScriptLmCache'=>60*60*24*360,
            ),

            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'useStrictParsing'=>true,
                #'class' => 'UrlManager',
                'rules'=>array(

                    // MinScript (контроллер минификатора)
                    '/min/serve' => 'min/serve',

                    '/' => 'content/default/index',

                    '/contact/submit' => 'contact/contact/index',
                    '/contact/submitwidget' => 'contact/contact/submitwidget',

                    '404' => 'content/default/404',

                    //'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),

            // mailer
            'mailer'=>array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),

            'bootstrap'=>array(
                'class'=>'ext.yiibooster.components.Bootstrap',
            ),

        ),

        // frontend модули
        'modules' => array(
            'content'=>array(),
            'contact'=>array()
        ),
    )
);

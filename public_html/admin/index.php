<?php

require_once( __DIR__ . '/../../app/config/settings.php' );
require_once( __DIR__ . '/../../composer/vendor/yiisoft/yii/framework/yiilite.php');

Yii::createWebApplication( __DIR__ . '/../../app/config/backend.php' )->run();

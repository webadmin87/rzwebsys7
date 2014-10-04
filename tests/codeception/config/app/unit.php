<?php

/**
 * Application configuration for app unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/main.php'),
    require(YII_APP_BASE_PATH . '/common/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/app/config/main.php'),
    require(YII_APP_BASE_PATH . '/app/config/main-local.php'),
    \common\helpers\ConfigHelper::getModulesConfigs($params["enabledModules"]),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);

<?php
use yii\helpers\Html;
use \common\widgets\launcher\Launcher;

echo Html::tag('h1', Yii::t('main/app', 'Tools'));

echo Html::tag('h2', Yii::t('main/app', 'Install roles'));
echo Launcher::widget(["url"=>"rbac/"]);

echo Html::tag('h2', Yii::t('main/app', 'Clear cache'));
echo Launcher::widget(["url"=>"clear-cache/"]);
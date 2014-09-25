<?php
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var app\modules\shop\models\Good $model
*/

echo ExtFilter::widget(["model"=>$model]);
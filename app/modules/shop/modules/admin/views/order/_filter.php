<?php
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var app\modules\shop\models\Order $model
*/

echo ExtFilter::widget(["model"=>$model]);
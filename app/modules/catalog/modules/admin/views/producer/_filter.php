<?php
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var app\modules\catalog\models\Producer $model
*/

echo ExtFilter::widget(["model"=>$model]);
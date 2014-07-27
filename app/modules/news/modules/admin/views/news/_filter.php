<?php
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var app\modules\news\models\News $model
*/

echo ExtFilter::widget(["model"=>$model]);
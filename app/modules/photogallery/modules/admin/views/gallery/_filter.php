<?php
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var app\modules\photogallery\models\Gallery $model
*/

echo ExtFilter::widget(["model"=>$model]);
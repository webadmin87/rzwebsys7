<?php
use common\widgets\admin\ExtFilter;

/**
 * @var yii\web\View $this
 * @var app\modules\catalog\models\CatalogSection $model
 */

echo ExtFilter::widget(["model" => $model]);
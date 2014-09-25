<?php

use common\widgets\admin\Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\catalog\models\CatalogSection $searchModel
 */

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'tree' => true,
    'userColumns' => [[
        'class' => \yii\grid\DataColumn::className(),
        'header' => Yii::t('catalog/app', 'Link'),
        'value' => function ($model, $index, $widget) {
            return Yii::$app->urlManager->createUrl(['/catalog/catalog/index', 'section' => $model->code]);
        }
    ]],
]);

?>
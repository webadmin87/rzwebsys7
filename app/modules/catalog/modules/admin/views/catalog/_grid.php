<?php

use common\widgets\admin\Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\catalog\models\Catalog $searchModel
 */

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'userColumns' => [[
        'class' => \yii\grid\DataColumn::className(),
        'header' => Yii::t('catalog/app', 'Link'),
        'value' => function ($model, $index, $widget) {
            return Yii::$app->urlManager->createUrl(['/catalog/catalog/detail', 'section' => $model->sections[0]->code, 'code' => $model->code]);
        }
    ]],
]);

?>
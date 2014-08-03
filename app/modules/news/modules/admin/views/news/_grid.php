<?php

use common\widgets\admin\Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\news\models\News $searchModel
 */

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'userColumns' => [[
        'class' => \yii\grid\DataColumn::className(),
        'header' => Yii::t('news/app', 'Link'),
        'value' => function ($model, $index, $widget) {
            return Yii::$app->urlManager->createUrl(['/news/news/detail', 'section' => $model->sections[0]->code, 'code' => $model->code]);
        }
    ]],
]);

?>
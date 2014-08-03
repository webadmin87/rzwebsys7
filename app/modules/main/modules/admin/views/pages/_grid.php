<?php
use common\widgets\admin\Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\main\models\Pages $searchModel
 */

?>

<?

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'tree' => true,
    'userColumns' => [[
        'class' => \yii\grid\DataColumn::className(),
        'header' => Yii::t('main/app', 'Link'),
        'value' => function ($model, $index, $widget) {
            return Yii::$app->urlManager->createUrl(['/main/pages/index', 'code' => $model->code]);
        }
    ]],
]);

?>
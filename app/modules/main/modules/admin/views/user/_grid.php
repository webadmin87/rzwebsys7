<?php
use common\widgets\admin\Grid;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\main\models\User $searchModel
 */
?>

<?
Pjax::begin();
echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
]);
Pjax::end();
?>
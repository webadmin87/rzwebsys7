<?php
use common\widgets\admin\Grid;
use yii\widgets\Pjax;
?>

<?
Pjax::begin();
echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'tree' => true,
]);
Pjax::end();
?>
<?php

use common\widgets\admin\Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\main\models\Includes $searchModel
 */

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
]);

?>
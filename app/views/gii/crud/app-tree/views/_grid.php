<?php

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";?>

use common\widgets\admin\Grid;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var <?= $generator->modelClass ?> $searchModel
*/

echo Grid::widget([
'dataProvider' => $dataProvider,
'model' => $searchModel,
'tree' => true,
]);

?>
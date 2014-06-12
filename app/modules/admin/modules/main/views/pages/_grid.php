<?php
use common\widgets\admin\Grid;
?>

<?

echo Grid::widget([
    'dataProvider' => $dataProvider,
    'model' => $searchModel,
    'tree' => true,
]);

?>
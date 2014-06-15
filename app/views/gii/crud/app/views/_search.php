<?php
/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>
use common\widgets\admin\ExtFilter;

/**
* @var yii\web\View $this
* @var <?=$generator->modelClass?> $model
*/

echo ExtFilter::widget(["model"=>$model]);
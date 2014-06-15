<?php
/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */
echo "<?php\n";
?>
use common\widgets\admin\Form;

/**
* @var <?=$generator->modelClass?> $model модель
*/

echo Form::widget(["model"=>$model]);
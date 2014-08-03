<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var <?= $generator->modelClass ?> $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><? echo '<?=' ?> Html::encode($this->title) ?></h1>

    <? echo '<?=' ?> $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

<?php
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var app\modules\catalog\models\Producer $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create Producer');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Producers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

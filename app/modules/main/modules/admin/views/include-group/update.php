<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var \app\modules\main\models\IncludeGroup $model
*/

$this->title = \Yii::t($this->context->tFile, 'Update Include Group').': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Include Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('core', 'Update');
?>
<div class="include-group-update">

    <h1><?=Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
    'model' => $model,
    ]) ?>

</div>


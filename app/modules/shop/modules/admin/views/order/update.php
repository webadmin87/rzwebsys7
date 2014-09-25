<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\modules\shop\models\Order $model
*/

$this->title = \Yii::t($this->context->tFile, 'Update Order').': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('core', 'Update');
?>
<div class="order-update">

    <h1><?=Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
    'model' => $model,
    ]) ?>

</div>


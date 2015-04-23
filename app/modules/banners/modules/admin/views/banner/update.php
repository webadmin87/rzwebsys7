<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\modules\banners\models\Banner $model
*/

$this->title = \Yii::t($this->context->tFile, 'Update Banner').': ' . $model->getItemLabel();
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('core', 'Update');
?>
<div class="banner-update">

    <h1><?=Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
    'model' => $model,
    ]) ?>

</div>


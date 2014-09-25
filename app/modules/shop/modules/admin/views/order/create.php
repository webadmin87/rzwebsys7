<?php
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var app\modules\shop\models\Order $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create Order');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

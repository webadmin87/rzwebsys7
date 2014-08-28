<?php
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var app\modules\banners\models\Banner $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create Banner');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

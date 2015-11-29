<?php
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var app\modules\main\models\Review $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create Review');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, Yii::t('main/app', 'Reviews')), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>

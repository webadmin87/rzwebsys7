<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var app\modules\main\models\Permission $model
 */

$this->title = \Yii::t($this->context->tFile, 'Create Permission');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

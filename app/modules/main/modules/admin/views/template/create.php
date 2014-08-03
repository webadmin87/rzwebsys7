<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var app\modules\main\models\Template $model
 */

$this->title = \Yii::t($this->context->tFile, 'Create Template');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

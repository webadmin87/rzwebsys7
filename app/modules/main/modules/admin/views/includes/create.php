<?php
use yii\helpers\Html;

/**
* @var \yii\web\View $this
* @var app\modules\main\models\Includes $model
*/

$this->title = \Yii::t($this->context->tFile, 'Create Includes');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Includes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var app\modules\catalog\models\Catalog $model
 */

$this->title = \Yii::t($this->context->tFile, 'Create Catalog');
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Catalog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

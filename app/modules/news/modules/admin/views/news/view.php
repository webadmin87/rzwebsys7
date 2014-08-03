<?php
use common\widgets\admin\CrudLinks;
use common\widgets\admin\Detail;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\news\models\News $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= CrudLinks::widget(["action" => CrudLinks::CRUD_VIEW, "model" => $model]) ?>
    </p>

    <?= Detail::widget([
        'model' => $model,
    ]) ?>

</div>
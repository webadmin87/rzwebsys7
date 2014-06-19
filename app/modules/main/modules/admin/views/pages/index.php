<?php
use yii\helpers\Html;
use common\widgets\admin\CrudLinks;
use yii\widgets\Breadcrumbs;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\main\models\Pages $searchModel
 * @var int $parent_id
 */

$this->title = \Yii::t($this->context->tFile,'Pages');

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_filter', ['model' => $searchModel]); ?>

    <hr />

    <p>
        <?=CrudLinks::widget(["action"=>CrudLinks::CRUD_LIST, "model"=>$searchModel, "urlParams"=>["parent_id"=>$parent_id]])?>
    </p>

    <?= Breadcrumbs::widget([
        'homeLink'=>[
            "label"=>\Yii::t($this->context->tFile, 'Root'),
            "url"=>["/".Yii::$app->controller->route]
        ],
        'links' => $searchModel->getBreadCrumbsItems($parent_id, "/".Yii::$app->controller->route),
    ]) ?>

    <?php echo $this->render('_grid', ['dataProvider' => $dataProvider, "searchModel"=>$searchModel]); ?>


</div>

<?php
use yii\helpers\Html;
use common\widgets\admin\CrudLinks;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\modules\photogallery\models\Gallery $searchModel
*/

$this->title = \Yii::t($this->context->tFile, 'Galleries');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_filter', ['model' => $searchModel]); ?>

    <hr/>

    <p>
        <?=CrudLinks::widget(["action"=>CrudLinks::CRUD_LIST, "model"=>$searchModel])?>
    </p>

    <?=$this->render('_grid', ['dataProvider' => $dataProvider, "searchModel"=>$searchModel]); ?>


</div>

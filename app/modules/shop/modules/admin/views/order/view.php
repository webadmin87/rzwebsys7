<?php
use yii\helpers\Html;
use common\widgets\admin\Detail;
use common\widgets\admin\CrudLinks;
/**
* @var yii\web\View $this
* @var app\modules\shop\models\Order $model
*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => \Yii::t($this->context->tFile, 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?=Html::encode($this->title) ?></h1>

    <p>
        <?=CrudLinks::widget(["action"=>CrudLinks::CRUD_VIEW, "model"=>$model])?>
    </p>

    <?=Detail::widget([
    'model' => $model,
    ]) ?>

    <h2><?=Yii::t('shop/app', 'Order items')?></h2>

    <?=$this->render("_order", ["order"=>$model])?>

    <?=Html::a(Yii::t('shop/app', 'Manage order'), ['/shop/admin/good/index', 'Good'=>['order_id'=>$model->id]], ["class"=>"btn btn-default", "target"=>"_blank"])?>

</div>
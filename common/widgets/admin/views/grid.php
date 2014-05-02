<?php
use yii\grid\GridView;
use yii\helpers\Html;
use Yii;
echo GridView::widget([
    "id"=>$id,
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
]);
?>

<div class="form-group form-inline">

    <span><?=Yii::t('core', 'Actions with selected')?>:</span>

    <?foreach($groupButtons AS $button):?>
        <?if(is_array($button)):?>
            <?=Html::button($button["title"], $button["options"])?>
        <?endif;?>
    <?endforeach;?>

</div>
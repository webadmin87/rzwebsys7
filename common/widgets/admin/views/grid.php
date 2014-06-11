<?php
use yii\grid\GridView;
use yii\helpers\Html;


/**
 * @var string $id идентификатор виджета
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var \common\db\ActiveRecord $model модель
 * @var array $columns массив с описанием полей таблицы
 * @var array $groupButtons массив с описанием кнопок груповых операций
 * @var \yii\web\View $this
 */

?>
<?=Html::beginForm();?>
<?
echo GridView::widget([
    "id" => $id,
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
]);
?>

<div class="form-group form-inline">

    <span><?= Yii::t('core', 'Actions with selected') ?>:</span>

    <? foreach ($groupButtons AS $button): ?>
        <? if (is_array($button)):
            $widget = Yii::createObject($button);
            ?>
            <?=$widget->run();?>
        <? endif; ?>
    <? endforeach; ?>

</div>
<?=Html::endForm();?>
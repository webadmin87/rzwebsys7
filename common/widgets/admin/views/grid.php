<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;


/**
 * @var string $id идентификатор виджета
 * @var string $pjaxId идентификатор виджета PJAX
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var \common\db\ActiveRecord $model модель
 * @var array $columns массив с описанием полей таблицы
 * @var array $groupButtons массив с описанием кнопок груповых операций
 * @var \yii\web\View $this
 */

?>
<?Pjax::begin(["id"=>$pjaxId]);?>
<?=Html::beginForm();?>
<?
echo GridView::widget([
    "id" => $id,
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => $columns,
]);
?>

<?
$btnHtml = null;
foreach ($groupButtons AS $button): ?>
    <? if (is_array($button)):
        $widget = Yii::createObject($button);
        ?>
        <?$btnHtml .= $widget->run() . "\n";?>
    <? endif; ?>
<? endforeach; ?>

<?if($btnHtml):?>
    <div class="form-group form-inline">

        <span><?= Yii::t('core', 'Actions with selected') ?>:</span>

        <?=$btnHtml?>

    </div>
<?endif;?>

<?=Html::endForm();?>
<?Pjax::end();?>
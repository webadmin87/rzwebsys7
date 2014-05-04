<?php
use yii\grid\GridView;
use yii\helpers\Html;
use Yii;

/**
 * @var string $id идентификатор виджета
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var \common\db\ActiveRecord $model модель
 * @var array $columns массив с описанием полей таблицы
 * @var array $groupButtons массив с описанием кнопок груповых операций
 * @var \yii\web\View $this
 */

?>
<?=HTML::beginForm();?>
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
        <? if (is_array($button)): ?>

            <?if (!empty($button["options"]["id"])):

                $url = $button["url"];

                $this->registerJs("

                    $('#{$button["options"]["id"]}').on('click', function(){

                       var form = $(this).parents('form');

                       form.attr('action', '{$url}');

                       form.submit();

                    });

                ");

            endif;
            ?>

            <?= Html::button($button["title"], $button["options"]) ?>
        <? endif; ?>
    <? endforeach; ?>

</div>
<?=HTML::endForm();?>
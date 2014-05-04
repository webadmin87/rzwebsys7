<?php
use yii\grid\GridView;
use yii\helpers\Html;
use Yii;

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
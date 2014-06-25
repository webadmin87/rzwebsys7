<?php
/**
 * @var \app\modules\main\models\Comments $model модель комментариев
 * @var int $marginStep шаг отступа
 */
$marginLeft = $marginStep*($model->level - 2);
?>

<div class="comments-item" id="comments-item-<?=$model->id?>" style="margin-left: <?=$marginLeft?>px">

    <div class="comments-info">

        <span class="comments-username"><?=$model->username?></span>

        <?if(!empty($model->email)):?>

            | <a href="mailto:<?=$model->email?>"><?=$model->email?></a>

        <?endif;?>

        | <?=Yii::$app->formatter->asDatetime($model->created_at)?>

    </div>

    <div class="comments-body">
        <?=$model->text?>
    </div>
    <div class="comments-tools">
        <a class="comments-re-link" href="#comments-add-form" data-id="<?=$model->id?>" data-username="<?=$model->username?>">Ответить</a> |
        <a class="comments-quote-link" href="#comments-add-form" data-id="<?=$model->id?>">Цитировать</a>
    </div>
</div>
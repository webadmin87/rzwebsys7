<?php
/**
 * @var \app\modules\catalog\models\Catalog $model модель элемента каталога
 * @var int $detailImageWidth ширина детального изображения
 */
$file = $model->getFirstFile('image');
?>

    <h1><?= $model->title ?></h1>
<? if ($file): ?>
    <a rel="news-item" class="photogallery" href="<?= $file->getRelPath() ?>">
        <img style="margin: 0 10px 5px 0" src="<?= Yii::$app->resizer->resize($file->getPath(), $detailImageWidth) ?>"
             alt="" align="left" class="img-thumbnail"/>
    </a>
<? endif; ?>
    <p class="date"><?= Yii::$app->formatter->asDecimal($model->price, 0) ?> <?=Yii::$app->formatter->currencyCode?></p>
<?= $model->text ?>
<?= \app\modules\shop\widgets\ToBasket::widget(["model"=>$model])?>
<?= \app\modules\main\widgets\gallery\Gallery::widget(["files" => $model->getFiles('image'), "skipFromStart" => 1, "rel" => "news-item"]); ?>

<?
if ($model->comments) {

    echo '<h3>' . Yii::t('main/app', 'Comments') . '</h3>';

    echo \app\modules\main\widgets\comments\Comments::widget(["modelClass" => get_class($model), "itemId" => $model->id]);

}
?>
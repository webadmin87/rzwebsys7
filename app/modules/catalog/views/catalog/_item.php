<?php
use yii\helpers\Url;

/**
 * @var \app\modules\catalog\models\Catalog $model модель элемента каталога
 * @var mixed $key
 * @var int $index
 * @var \yii\widgets\ListView $widget
 * @var int $previewImageWidth ширина изображения
 * @link http://www.yiiframework.com/doc-2.0/yii-widgets-listview.html#$itemView-detail
 */
$file = $model->getFirstFile('image');
$url = Url::toRoute($model->getLink());
?>

<h2><a href="<?= $url ?>"><?= $model->title ?></a></h2>
<? if ($file): ?>
    <a href="<?= $url ?>">
        <img style="margin: 0 10px 5px 0" src="<?= Yii::$app->resizer->resize($file->getPath(), $previewImageWidth) ?>"
             alt="" align="left" class="img-thumbnail"/>
    </a>
<? endif; ?>
<p><?= $model->annotation ?></p>
<p class="price"><?=Yii::$app->formatter->asCurrency($model->price) ?></p>

<?php
use yii\helpers\Url;

/**
 * @var \app\modules\news\models\News $model модель новостей
 * @var mixed $key
 * @var int $index
 * @var \yii\widgets\ListView $widget
 * @var int $previewImageWidth ширина изображения
 * @link http://www.yiiframework.com/doc-2.0/yii-widgets-listview.html#$itemView-detail
 */
$file = $model->getFirstFile('image');
$url = Url::toRoute(['/news/news/detail', 'section' => $model->sections[0]->code, 'code' => $model->code]);
?>
<h2><a href="<?= $url ?>"><?= $model->title ?></a></h2>
<? if ($file): ?>
    <a href="<?= $url ?>">
        <img style="margin: 0 10px 5px 0" src="<?= Yii::$app->resizer->resize($file->getPath(), $previewImageWidth) ?>"
             alt="" align="left" class="img-thumbnail"/>
    </a>
<? endif; ?>
<p><?= $model->annotation ?></p>
<p class="date"><?= Yii::$app->formatter->asDate($model->date) ?></p>
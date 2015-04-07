<?php
use yii\helpers\Url;

/**
 * @var \app\modules\photogallery\models\Gallery $model модель
 * @var mixed $key
 * @var int $index
 * @var \yii\widgets\ListView $widget
 * @link http://www.yiiframework.com/doc-2.0/yii-widgets-listview.html#$itemView-detail
 */
$file = $model->getFirstFile('image');
$url = Url::toRoute(["/photogallery/default/detail", "code"=>$model->code]);
?>

<h2><a href="<?= $url ?>"><?= $model->title ?></a></h2>
<? if ($file): ?>
    <a href="<?= $url ?>">
        <img src="<?= Yii::$app->resizer->resize($file->getPath(), 200, 200) ?>"
             alt="" class="img-thumbnail"/>
    </a>
<? endif; ?>


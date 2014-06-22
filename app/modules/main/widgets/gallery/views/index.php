<?php
/**
 * @var \common\core\File[] $files массив файлов
 * @var int $width ширина изображения
 * @var int $height высота изображения
 * @var array $options массив Html атрибутов
 */

use yii\helpers\Html;

echo  Html::beginTag('div', $options);

foreach($files AS $file) {

    if(!$file->isImage())
        continue;

    $src = Yii::$app->resizer->resize($file->getPath(), $width, $height);

    echo Html::tag('div', Html::img($src));

}


echo Html::endTag('div');
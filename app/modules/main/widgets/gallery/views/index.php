<?php
/**
 * @var \common\core\File[] $files массив файлов
 * @var int $width ширина изображения
 * @var int $height высота изображения
 * @var array $options массив Html атрибутов
 * @var string $rel значение атрибута rel
 */

use yii\helpers\Html;

echo Html::beginTag('div', $options);

foreach ($files AS $file) {

    if (!$file->isImage())
        continue;

    $src = Yii::$app->resizer->resize($file->getPath(), $width, $height);

    echo Html::tag('div', Html::a(Html::img($src), $file->getRelPath(), ["rel" => $rel]));

}

echo Html::endTag('div');
<?php
/**
 * @var array $models массив моделей меню
 * @var array $options массив html атрибутов корневого Ul
 * @var closure $urlCreate функция для содания url
 * @var string $labelAttr имя выводимого атрибута
 */

use yii\helpers\Html;

echo Html::beginTag('ul', $options) . "\n";

foreach ($models AS $model) {

    $link = "";

    if (is_callable($urlCreate))
        $link = $urlCreate($model);

    echo Html::tag('li', Html::a($model->$labelAttr, $link));

}

echo Html::endTag('ul');



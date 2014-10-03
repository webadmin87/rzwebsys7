<?php
/**
 * @var array $models массив моделей меню
 * @var int $parentLevel уровень вложенности родительского пункта меню
 * @var array $options массив html атрибутов корневого Ul
 * @var string $actClass имя класса активного пункта меню
 * @var closure $urlCreate функция для содания url
 * @var string $labelAttr имя выводимого атрибута
 */

use yii\helpers\Html;

echo Html::beginTag('ul', $options) . "\n";

foreach ($models AS $model) {

    // Для всех кроме первой итерации

    if (isset($level)) {

        if ($model->level == $level) {
            echo "</li>\n";
        } elseif ($model->level > $level) {
            echo "<ul>\n";
        } else {
            echo str_repeat("</li>\n</ul>\n", $level - $model->level);
            echo "</li>\n";
        }
    }

    $link = "";

    if (is_callable($urlCreate))
        $link = $urlCreate($model);

    $o = [];

    if ($this->context->isAct($link))
        Html::addCssClass($o, $actClass);

    echo Html::beginTag('li', $o) . Html::a($model->$labelAttr, $link);

    $level = $model->level;

}

echo str_repeat("</li>\n</ul>\n", $level - $parentLevel);

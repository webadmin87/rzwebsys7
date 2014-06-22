<?php
/**
 * @var array $models массив моделей меню
 * @var int $parentLevel уровень вложенности родительского пункта меню
 * @var array $options массив html атрибутов корневого Ul
 * @var string $actClass имя класса активного пункта меню
 */

use yii\helpers\Html;

echo Html::beginTag('ul', $options)."\n";

foreach ($models AS $model) {

    // Для всех кроме первой итерации

    if (isset($level)) {

        if ($model->level == $level) {
            echo "</li>\n";
        }
        elseif ($model->level > $level) {
            echo "<ul>\n";
        }
        else {
            echo str_repeat("</li>\n</ul>\n", $level - $model->level);
            echo "</li>\n";
        }
    }

    $o = [];

    if($model->isAct())
        Html::addCssClass($o,$actClass);

    if(!empty($model->class))
        Html::addCssClass($o,$model->class);

    echo Html::beginTag('li', $o) . Html::a( $model->title, $model->link, ["target"=>$model->target]);


    $level = $model->level;

}

echo str_repeat("</li>\n</ul>\n", $level - $parentLevel);
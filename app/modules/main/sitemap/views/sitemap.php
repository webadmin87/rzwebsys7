<?php
/**
 * @var array $elements масиив с картой сайта
 */

use yii\helpers\Html;
use common\db\TActiveRecord;

foreach($elements AS $elem) {

    if(empty($elem["items"]))
        continue;

    $h = !empty($elem["entityUrl"])?Html::a($elem["header"],$elem["entityUrl"]):$elem["header"];

    echo Html::tag('h2', $h);

    echo Html::beginTag('ul');

    foreach($elem["items"] AS $item) {

        $a = Html::a($item["label"], $item["url"]);

        echo Html::tag('li', $a);

    }

    echo Html::endTag('ul');


}
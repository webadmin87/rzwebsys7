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

    if($elem["items"][0] instanceof TActiveRecord)
        echo \app\modules\main\widgets\treelist\TreeList::widget(["labelAttr"=>$elem["labelAttr"], "models"=>$elem["items"], "urlCreate"=>$elem["urlCreate"]]);
    else
        echo \app\modules\main\widgets\elist\EList::widget(["labelAttr"=>$elem["labelAttr"], "models"=>$elem["items"], "urlCreate"=>$elem["urlCreate"]]);


}
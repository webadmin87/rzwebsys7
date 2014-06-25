<?php
use common\widgets\ListView;
/**
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var int $marginStep шаг отступ
 */

echo ListView::widget([
    "dataProvider"=>$dataProvider,
    "itemView"=>"_item",
    "viewParams"=>["marginStep"=>$marginStep],
    "summary"=>"",
    "emptyText"=>Yii::t("main/app", "Be the first to leave a comment"),
]);
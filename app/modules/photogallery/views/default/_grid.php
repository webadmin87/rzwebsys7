<?php
/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 */

echo \yii\widgets\ListView::widget([
	"dataProvider" => $dataProvider,
	"itemView" => "_item",
	'summary' => '',
    "options" => [
        "class"=>"row",
    ],
	"itemOptions" => [
		'class' => 'col-xs-12 col-sm-6 col-md-4 gallery-item'
	],
    "pager"=>[
        "options"=>[
            "class"=>"pagination clear",
        ],
    ],
]);
?>
<?php
/**
 * @var yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var int $previewImageWidth ширина изображения
 */

echo \yii\widgets\ListView::widget([
	"dataProvider" => $dataProvider,
	"itemView" => "_item",
	'summary' => '',
	"viewParams" => [
		"previewImageWidth" => $previewImageWidth,
	],
	"itemOptions" => [
		'class' => 'clearfix'
	],
]);
?>
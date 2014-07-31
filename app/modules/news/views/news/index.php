<?php
/**
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var int $previewImageWidth ширина изображения
 * @var \app\modules\news\models\NewsSection|null $sectionModel модель категории
 */
?>
<h1><?=$sectionModel?$sectionModel->title:Yii::t('news/app', 'News')?></h1>
<?
echo \yii\widgets\ListView::widget([
    "dataProvider"=>$dataProvider,
    "itemView"=>"_item",
    'summary'=>'',
    "viewParams"=>[
        "previewImageWidth"=>$previewImageWidth,
    ],
    "itemOptions"=>[
        'class'=>'clearfix'
    ],
]);
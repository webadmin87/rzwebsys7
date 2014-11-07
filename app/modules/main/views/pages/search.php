<?php
/**
 * @var string $term поисковая фраза
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 */
?>
<h1><?=Yii::t('main/app', 'Search results: {term}', ["term"=>$term])?></h1>
<?=\yii\widgets\ListView::widget(["itemView"=>"_search", "dataProvider"=>$dataProvider, "summary"=>""])?>
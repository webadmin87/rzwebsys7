<?php
/**
 * @var yii\web\View $this
 */
use app\modules\catalog\models\CatalogSection;
use yii\helpers\Url;

echo app\modules\main\widgets\treelist\TreeList::widget([
	"modelClass"=>CatalogSection::className(),
	"parentId"=>1,
	"urlCreate"=>function($model){
		return Url::toRoute(['/catalog/catalog/index', 'section'=>$model->code]);
	}
]);

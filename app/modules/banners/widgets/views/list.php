<?php
/**
 * @var \app\modules\banners\models\Banner[] $models массив моделей баннеров
 * @var array $containerOptions массив атрибутов тега - контейнера
 */

use yii\helpers\Html;

echo Html::beginTag('ul', $containerOptions);

foreach($models AS $model) {

	echo Html::beginTag('li');

	$renderer = \app\modules\banners\components\AbstractRenderer::getRenderer($model);

	echo $renderer->render();

	echo Html::endTag('li');

}

echo Html::endTag('ul');
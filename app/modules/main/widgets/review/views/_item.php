<?php
/**
 * @var \common\components\View $this
 * @var \app\modules\main\models\Review $model
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;

echo Html::beginTag('div', ['class' => 'review-item', 'id'=>"comment-item-$model->id"]);

echo Html::beginTag('div', ['class' => 'review-info']);

echo Html::tag('span', $model->username, ['class' => 'review-username']);

if (!empty($model->email)) {
	echo '&nbsp;|&nbsp;';
	echo Html::mailto($model->email, null, ['class' => 'review-email']);
}

echo '&nbsp;|&nbsp;';
echo Html::tag('span', Yii::$app->formatter->asDatetime($model->created_at), ['class' => 'review-date']);

echo Html::endTag('div');

$options = ArrayHelper::merge($model->metaFields->rating->inputClass['widgetOptions'], [
	'name' => "review-rating-$model->id",
	'value' => $model->rating,
	'readonly' => true,
	'pluginOptions' => [
		'size' => 'xs'
	]
]);

echo Html::tag('div', StarRating::widget($options), ['class' => 'review-rating']);

echo Html::tag('div', $model->text, ['class' => 'review-text']);

echo Html::endTag('div');
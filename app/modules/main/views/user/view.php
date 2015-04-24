<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\components\View $this
 * @var \app\modules\main\models\User $model модель пользователя
 */

$this->title = Yii::t('main/app', 'User Profile');
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title.' '.$model->username);

echo \yii\widgets\DetailView::widget([
	'model' => $model,
	'attributes' => [
		'username',
		'email',
		'name',
	],
]);
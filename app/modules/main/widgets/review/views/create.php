<?php
/**
 * @var \common\components\View $this
 * @var string $id идентификатор виджета
 * @var \app\modules\main\models\Review $model модель льзыва
 * @var array $formOptions параметры формы
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo Html::beginTag('div', ['id' => $id]);

$form = ActiveForm::begin($formOptions);

echo Html::tag('div', Yii::t('main/app', 'Review Success Message'), ['class' => 'review-success alert alert-success', 'style' => 'display:none;']);
echo Html::tag('div', Yii::t('main/app', 'Review Error Message'), ['class' => 'review-error alert alert-danger', 'style' => 'display:none;']);

echo $model->metaFields->username->getForm($form);

echo $model->metaFields->email->getForm($form);

echo $model->metaFields->rating->getForm($form);

echo $model->metaFields->text->getForm($form);

echo Html::activeHiddenInput($model, 'model');
echo Html::activeHiddenInput($model, 'item_id');
echo Html::activeHiddenInput($model, 'source_model');
echo Html::activeHiddenInput($model, 'source_item_id');

echo Html::beginTag('div', ['class' => 'form-group']);
echo Html::submitButton(Yii::t('main/app', 'Submit'), ['class' => 'review-add btn btn-primary']);
echo Html::endTag('div');

ActiveForm::end();

echo Html::endTag('div');
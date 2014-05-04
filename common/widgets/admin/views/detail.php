<?php
use yii\widgets\DetailView;

/**
 * @var \common\db\ActiveRecord $model модель
 * @var array $attributes массив описанй атрибутов
 * @var string $id идентификатор виджета
 */


echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
]);
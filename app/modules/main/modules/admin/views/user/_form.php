<?php
use common\widgets\admin\Form;

/**
 * @var yii\web\View $this
 * @var \common\db\ActiveRecord $model модель
 */

echo Form::widget(["model" => $model]);
<?php
use common\widgets\admin\Form;

/**
 * @var \common\db\ActiveRecord $model модель
 */

echo Form::widget(["model"=>$model]);
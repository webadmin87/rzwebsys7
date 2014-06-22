<?php
/**
 * @var \common\components\View $this
 * @var \app\modules\main\models\Pages $model модель текстовой страницы
 */

echo $model->text;

echo \app\modules\main\widgets\gallery\Gallery::widget(["files"=>$model->getFiles('image')]);
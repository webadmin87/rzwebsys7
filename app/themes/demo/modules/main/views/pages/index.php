<?php
/**
 * @var \common\components\View $this
 * @var \app\modules\main\models\Pages $model модель текстовой страницы
 */

echo $model->text;

echo \app\modules\main\widgets\gallery\Gallery::widget(["files"=>$model->getFiles('image')]);

if($model->comments) {

    echo '<h3>'.Yii::t('main/app', 'Comments').'</h3>';

    echo \app\modules\main\widgets\comments\Comments::widget(["modelClass"=>get_class($model), "itemId"=>$model->id]);

}
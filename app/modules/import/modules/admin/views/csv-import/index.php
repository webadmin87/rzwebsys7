<?php
/**
 * @var \app\modules\import\models\CsvModel $model модель
 * @var array $classes
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<h1><?= Yii::t('import/app', 'Csv import') ?></h1>

<div class="row">
    <div class="co-xs-12 col-md-7 col-lg-5">

        <?php
        $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'modelClass')->dropDownList($classes) ?>

        <?= $form->field($model, 'filePath')->widget(\mihaildev\elfinder\InputFile::className(), [
            "template"=>'<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            "options" => [
                "class" => "form-control"
            ],
            "buttonOptions" => [
                "class" => "btn btn-default"
            ],
        ]) ?>

        <?= $form->field($model, 'headLine')->checkbox(); ?>

        <?= $form->field($model, 'key') ?>

        <?= $form->field($model, 'delimiter') ?>

        <?= $form->field($model, 'enclosure') ?>

        <?= $form->field($model, 'escape') ?>

        <div class="form-group">

            <?= Html::submitButton(Yii::t('import/app', 'Continue'), ['class' => 'btn btn-primary']) ?>

        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
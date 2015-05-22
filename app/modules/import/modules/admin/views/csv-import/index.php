<?php
/**
 * @var \app\modules\import\models\CsvModel $model модель
 * @var array $classes массив доступных классов
 */

use common\widgets\DependDropDown;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('import/app', 'Csv import');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="row">
    <div class="co-xs-12 col-md-7 col-lg-5">

        <?php
        $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'modelClass')->widget(DependDropDown::className(), [
            "dependAttr"=>"key",
            "source"=>["/import/admin/csv-import/keys"],
            "data"=>$classes,
            "serverAttr"=>"cls",
            "triggerChange"=>true,
            "options"=>["class"=>"form-control"],
        ]) ?>

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

        <?= $form->field($model, 'key')->widget(DependDropDown::className(), [
            "options"=>["class"=>"form-control"],
        ]); ?>

        <?= $form->field($model, 'delimiter') ?>

        <?= $form->field($model, 'enclosure') ?>

        <?= $form->field($model, 'escape') ?>

        <?= $form->field($model, 'validate')->checkbox(); ?>

        <div class="form-group">

            <?= Html::submitButton(Yii::t('import/app', 'Continue'), ['class' => 'btn btn-primary']) ?>

        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
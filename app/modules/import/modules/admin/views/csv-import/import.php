<?php
/**
 * @var \app\modules\import\models\CsvModel $model модель
 * @var \common\db\ActiveRecord $importModel
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<h1><?= Yii::t('import/app', 'Attributes to columns mapping') ?></h1>

<div class="row">
    <div class="co-xs-12 col-md-7 col-lg-5">

        <?php
        $form = ActiveForm::begin() ?>

        <?foreach($importModel->getCsvAttributes() as $attr):?>

            <div class="row">

                <div class="col-xs-4">
                    <?=$importModel->getAttributeLabel($attr)?>:
                </div>

                <div class="col-xs-8">
                    <?= $form->field($model, "mapping[$attr]")->dropDownList($model->getColumns(), ['prompt'=>'']) ?>
                </div>

            </div>

        <?endforeach;?>

        <div class="form-group">

            <?= Html::submitButton(Yii::t('import/app', 'Start import'), ['class' => 'btn btn-primary']) ?>

            <?= Html::a(Yii::t('import/app', 'Back'), ['/import/admin/csv-import'], ['class'=>'btn btn-default']) ?>

        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
<?php
/**
 * @var \app\modules\import\models\CsvModel $model модель
 * @var \common\db\ActiveRecord $importModel
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = Yii::t('import/app', 'Attributes to columns mapping');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="row">
    <div class="co-xs-12 col-md-8 col-lg-6">

        <table class="table table-striped">
            <tbody>
                <?php
                $form = ActiveForm::begin() ?>

                <?foreach($importModel->getCsvAttributes() as $attr):?>
                    <tr>
                        <td>
                            <span class="label label-default"><?=$importModel->getAttributeLabel($attr)?>:</span>
                        </td>
                        <td>
                            <?= $form->field($model, "mapping[$attr]")->dropDownList($model->getColumns(), ['prompt'=>'']) ?>
                        </td>
                    </tr>
                <?endforeach;?>
            </tbody>
        </table>
        <div class="form-group">

            <?= Html::submitButton(Yii::t('import/app', 'Start import'), ['class' => 'btn btn-primary']) ?>

            <?= Html::a(Yii::t('import/app', 'Back'), ['/import/admin/csv-import'], ['class'=>'btn btn-default']) ?>

        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
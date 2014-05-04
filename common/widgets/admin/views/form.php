<?php
use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\db\ActiveRecord $model модель
 * @var \yii\web\View $this
 * @var string $id идентификатор виджета
 * @var array $formOptions параметры \yii\widgets\ActiveForm
 */

$meta = $model->getMetaFields();

$tabId = "$id-tabs";

$this->registerJs("
    $('#{$tabId} a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
");

?>

<? $form = ActiveForm::begin($formOptions); ?>
    <ul id="<?= $tabId ?>" class="nav nav-tabs">
        <?
        $i = 0;
        foreach ($meta->tabs() AS $key => $title):?>
            <li <? if ($i == 0): ?>class="active"<? endif; ?>><a href="#<?= $key ?>"><?= $title ?></a></li>
            <?
            $i++;
        endforeach;?>
    </ul>

    <div class="tab-content">
        <?
        $i = 0;
        foreach ($meta->tabs() AS $key => $title): ?>
            <div class="<? if ($i == 0): ?>active <? endif; ?>tab-pane" id="<?= $key ?>">

                <? foreach ($meta->getFieldsByTab($key) AS $field): ?>
                    <?= $field->form($form); ?>
                <? endforeach; ?>

            </div>
            <?
            $i++;
        endforeach; ?>
    </div>


<?= Html::hiddenInput('apply', 0) ?>

<?$returnUrl = Yii::$app->request->post('returnUrl', Yii::$app->request->referrer);?>

<?= Html::hiddenInput('returnUrl', $returnUrl) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('core', 'Apply'), ['class' => 'btn btn-primary', 'onClick' => '$("input[name=\'apply\']").val(1)']) ?>
        <?= Html::submitButton(Yii::t('core', 'Cancel'), ['class' => 'btn btn-default', 'onClick' => "window.location.href='$returnUrl'"]) ?>

    </div>

<? ActiveForm::end(); ?>
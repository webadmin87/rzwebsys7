<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
/**
 * @var \common\db\ActiveRecord $model модель
 * @var \yii\web\View $this
 * @var string $id идентификатор виджета
 * @var array $formOptions параметры \yii\widgets\ActiveForm
 */

$perm = $model->getPermission();

$meta = $model->getMetaFields();

$tabId = "$id-tabs";

$this->registerJs("
    $('#{$tabId} a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
");

?>

<? $form = ActiveForm::begin($formOptions); ?>

<? echo $form->errorSummary($model); ?>

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
        
 	foreach ($meta->tabs() AS $key => $title):
            $tpl = [];
            $html = '';
            $template = $this->context->getTplFile($key);
            ?>

            <div class="<? if ($i == 0): ?>active <? endif; ?>tab-pane" id="<?= $key ?>">

                <?php

                    foreach ($meta->getFieldsByTab($key) AS $field) {

                        if ($perm AND $perm->isAttributeForbidden($field->attr)) {

                            if(strpos($template, '{' . $field->attr . '}') !== false) {
                                $tpl['search'][] = '/{' . $field->attr . '}/';
                                $tpl['replace'][] = '';
                            }

                            continue;
                        }

                        if ($template && strpos($template, '{' . $field->attr . '}') !== false) {
                            $tpl['search'][] = '/{' . $field->attr . '}/';
                            $tpl['replace'][] = $field->getWrappedForm($form);
                        } else {
                            $html .= $field->getWrappedForm($form);
                        }

                    }

                    if(!empty($tpl))
                        echo preg_replace($tpl['search'], $tpl['replace'], $template);

                    echo $html;

                ?>

            </div>

            <?php
            $i++;
        endforeach; ?>
    </div>


<?= Html::hiddenInput('apply', 0) ?>

<?= Html::hiddenInput('tab', Yii::$app->request->post('tab')) ?>

<? $returnUrl = Yii::$app->request->get('returnUrl', Yii::$app->request->post('returnUrl', Yii::$app->request->referrer)); ?>

<?= Html::hiddenInput('returnUrl', $returnUrl) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('core', 'Apply'), ['class' => 'btn btn-primary form-apply']) ?>
        <?= Html::button(Yii::t('core', 'Cancel'), ['class' => 'btn btn-default form-cancel']) ?>

    </div>

<?php
$this->registerJs("

    (function(){

        $('.form-apply').on('click', function(e){ $(\"input[name='apply']\").val(1);});
	    $('.form-cancel').on('click', function(e){ e.preventDefault(); window.location.href='$returnUrl'; });
	    $('#$tabId a').on('show.bs.tab', function(){ $('[name=\"tab\"]').val($(this).attr('href')) });

        var activeTab = $('[name=\"tab\"]').val();

        if(activeTab) {
            $('#$tabId a[href=\"'+activeTab+'\"]').tab('show');
        }

    })();

");
?>

<? ActiveForm::end(); ?>

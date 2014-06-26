<?php
use common\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * @var \app\modules\main\widgets\comments\Comments $model модель комментариев
 * @var \yii\data\ActiveDataProvider $dataProvider провайдер данных
 * @var int $marginStep шаг отступ
 * @var array $formOptions настройки формы
 * @var string $editorClass класса виджета редактора комментариев
 * @var array $editorOptions настройки виджета комментариев
 * @var int $id идентификатор виджета
 */
?>
<div class="comments-ok alert alert-success"></div>
<div class="comments-error alert alert-danger"></div>
<?php
echo Html::beginTag('div', ['id'=>$id]);

$form = ActiveForm::begin($formOptions);

echo $form->field($model, 'username');

echo$form->field($model, 'email');

echo$form->field($model, 'text')->widget($editorClass, $editorOptions);

echo Html::activeHiddenInput($model, 'model');

echo Html::activeHiddenInput($model, 'item_id');

echo Html::hiddenInput("parent_id");

?>
<div class="form-group">
    <?=Html::submitButton(Yii::t('main/app', 'Submit'), ["class"=>"comments-add btn btn-primary"]);?>
</div>
<?
ActiveForm::end();

echo ListView::widget([
    "dataProvider"=>$dataProvider,
    "itemView"=>"_item",
    "viewParams"=>["marginStep"=>$marginStep],
    "summary"=>"",
    "emptyText"=>Yii::t("main/app", "Be the first to leave a comment"),
]);

echo Html::endTag('div');
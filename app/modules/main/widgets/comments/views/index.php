<?php
use common\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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

<?php
echo Html::beginTag('div', ['id' => $id]);
?>
    <div class="comments-ok alert alert-success"><?= Yii::t('main/app', 'Comment added successfully') ?></div>
    <div class="comments-error alert alert-danger"><?= Yii::t('main/app', 'Error when adding a comment') ?></div>
    <a name="comments-add-form"></a>
    <div class="comments-re-wrapper"><strong>RE:</strong> <span class="comments-re-info"></span> [<a
            class="comments-re-cancel" href="#"><?= Yii::t('main/app', 'Cancel') ?></a>]
    </div>
<?
$form = ActiveForm::begin($formOptions);

echo $form->field($model, 'username');

echo $form->field($model, 'email');

echo $form->field($model, 'text')->widget($editorClass, $editorOptions);

echo Html::activeHiddenInput($model, 'model');

echo Html::activeHiddenInput($model, 'item_id');

echo Html::hiddenInput("parent_id");

echo \common\widgets\JsCaptcha::widget(["model" => $model, "attribute" => "verifyCode", "value" => $model::VERIFY_CODE]);

?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('main/app', 'Submit'), ["class" => "comments-add btn btn-primary"]); ?>
    </div>
<?
ActiveForm::end();

Pjax::begin(["id" => "pjax-$id"]);

echo ListView::widget([
    "dataProvider" => $dataProvider,
    "itemView" => "_item",
    "viewParams" => ["marginStep" => $marginStep],
    "summary" => "",
    "emptyText" => Yii::t("main/app", "Be the first to leave a comment"),
]);

Pjax::end();

echo Html::endTag('div');
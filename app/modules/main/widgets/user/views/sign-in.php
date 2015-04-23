<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \app\modules\main\models\LoginForm $model
 * @var array $formOptions параметры формы
 */
?>

<?php $form = ActiveForm::begin($formOptions); ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'rememberMe')->checkbox() ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('main/app', 'Enter'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>
<?php ActiveForm::end(); ?>
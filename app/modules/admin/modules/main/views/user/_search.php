<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\main\models\UserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-search" style="display: none;">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?php echo $form->field($model, 'email') ?>

    <?php echo $form->field($model, 'role') ?>

    <?php echo $form->field($model, 'status') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<p>
    <?= Html::button('Extended search', ['class' => 'btn btn-default', 'onClick'=>'$(".user-search").toggle()']) ?>
</p>
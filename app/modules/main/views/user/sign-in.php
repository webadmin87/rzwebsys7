<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \app\modules\main\models\LoginForm $model
 */
$this->title = Yii::t('main/app', 'User SignIn');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <? echo \app\modules\main\widgets\user\SignIn::widget(["model" => $model]); ?>
        </div>
    </div>
</div>

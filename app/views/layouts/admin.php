<?php

use common\widgets\admin\Menu;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
?>
<? $this->beginContent('@app/views/layouts/admin-wrapper.php'); ?>
<div class="container">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            "label" => Yii::t('core', 'Start'),
            "url" => Yii::$app->urlManager->createUrl("/admin")
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">

        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
            <?php
            if ($this->beginCache("adminMenu", ['variations' => [Yii::$app->user->identity->role]])) {
                echo Menu::widget();
                $this->endCache();
            }
            ?>
        </div>

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-10">
            <?= $content ?>
        </div>

    </div>

</div>



<? $this->endContent(); ?>

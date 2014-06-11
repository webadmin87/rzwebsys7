<?php

use yii\widgets\Breadcrumbs;
use yii\bootstrap\Nav AS Menu;
/**
 * @var \yii\web\View $this
 * @var string $content
 */
?>
<?$this->beginContent('@app/views/layouts/admin-wrapper.php');?>
<div class="container">
    <?= Breadcrumbs::widget([
        'homeLink'=>[
            "label"=>Yii::t('core', 'Start'),
            "url"=>Yii::$app->urlManager->createUrl("/admin")
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">

        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
           <?
           echo Menu::widget([
               'route'=>$this->context->uniqueId,
               'items' => $this->context->menuItems?$this->context->menuItems:[],
               'options' => [
                   'class'=>'nav nav-pills nav-stacked'
               ]
           ]);
           ?>
        </div>

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <?= $content ?>
        </div>

    </div>

</div>



<?$this->endContent();?>

<?php
use app\themes\demo\assets\AppAsset;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="top">
    <div class="container">
        <h1><?=Yii::$app->name?></h1>
        <p>CMS powered by Yii Framework 2</p>
    </div>
</div>

<div class="container" id="content">
    <div class="row">
        <div class="col-xs-3">

            <? echo \app\modules\main\widgets\menu\Menu::widget(["options"=>["class"=>"nav nav-pills nav-stacked"], "parentId"=>2]);?>

        </div>
        <div  class="col-xs-9"><?= $content ?></div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Churkin Anton <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

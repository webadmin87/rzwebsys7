<?php
use app\themes\demo\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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

    <?php
    echo newerton\fancybox\FancyBox::widget([
        'target' => '.yii-gallery a, .photogallery',
        'helpers' => true,
        'mouse' => true,
        'config' => [
            'helpers' => [
                'title' => ['type' => 'float'],
                'buttons' => [],
                'thumbs' => ['width' => 68, 'height' => 50],
                'overlay' => [
                    'css' => [
                        'background' => 'rgba(0, 0, 0, 0.8)'
                    ]
                ]
            ],
        ]
    ]);?>

</head>
<body>
<?php $this->beginBody() ?>

<div id="top">
    <div class="container">
        <h1><?= Yii::$app->name ?></h1>

        <p>CMS powered by Yii Framework 2</p>
    </div>
</div>

<div class="container" id="content">
    <div class="row">
        <div class="col-xs-3">

            <?if(!Yii::$app->user->isGuest):?>
                <p>
                    <?=Html::a(Yii::t('core', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', ['/site/logout'], ['class'=>"btn btn-default"])?>
                </p>
            <?endif;?>

            <? echo \app\modules\main\widgets\menu\Menu::widget(
                [
                    "options" => ["class" => "nav nav-pills nav-stacked"],
                    "parentCode" => Yii::$app->getModule('main')->blocksProvider->getMenu('left', 'main'),
                ]
            ); ?>

            <br/>

            <div class="well">
                <? echo \app\modules\main\widgets\includes\Includes::widget(
                    [
                        "code" => Yii::$app->getModule('main')->blocksProvider->getArea('left', 'demo'),
                    ]
                );?>
            </div>

        </div>
        <div class="col-xs-9">
            <? echo Breadcrumbs::widget([
                'links' => $this->breadCrumbs,
            ]);?>
            <?= $content ?>
        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Churkin Anton <?= date('Y') ?> <a href=""
                                                                      class="feedback"><?= Yii::t('main/app', 'Feedback') ?></a>
        </p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php echo \app\modules\main\widgets\feedback\Feedback::widget(["fancySelector" => ".feedback"]); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

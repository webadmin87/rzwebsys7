<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\photogallery\models\Gallery $model
 */
?>
<h1><?=$this->title?></h1>
<div class="row clearfix">

    <?foreach($model->getFiles('image') AS $file):?>

    <div class="col-xs-12 col-sm-6 col-md-4 gallery-item">

        <a class="photogallery" href="<?= $file->getRelPath() ?>" rel="photallery-<?=$model->id?>">
            <img src="<?= Yii::$app->resizer->resize($file->getPath(), 200, 200) ?>"
                 alt="" class="img-thumbnail"/>
        </a>

    </div>

    <?endforeach;?>

</div>
<?=$model->text?>
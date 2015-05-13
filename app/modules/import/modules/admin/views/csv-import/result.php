<?php
/**
 * @var array|bool $res
 */
?>

<h1><?=Yii::t('import/app', 'Import finished')?></h1>

<?if(!$res):?>

    <div class="alert alert-danger"><?=Yii::t('import/app', 'Import error')?></div>

<?else:?>

    <div class="alert alert-success">

        <p><?=Yii::t('import/app', 'Success')?>: <?=$res["ok"]?></p>
        <p><?=Yii::t('import/app', 'Errors')?>: <?=$res["errors"]?></p>

    </div>

<?endif;?>
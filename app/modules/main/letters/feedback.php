<?php
/**
 * @var \app\modules\main\models\FeedbackForm $model модель формы обратной связи
 */
$attrs = $model->getAttributes();
?>
<?foreach($attrs AS $k => $v):?>
    <p><strong><?=$model->getAttributeLabel($k)?>:</strong> <?=$v?></p>
<?endforeach;?>
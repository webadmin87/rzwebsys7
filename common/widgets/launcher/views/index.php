<?php
use yii\helpers\Html;

/**
 * @var string $id идентификатор виджета
 * @var string label текст ссылки
 */

echo Html::beginTag('div', ["id" => $id]);

?>

    <div class="alert launcher-label" style="display: none;"></div>

    <div class="progress">
        <div class="progress-bar launcher-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    <a class="btn btn-primary launcher-btn"><?= $label ?></a>
<?
echo Html::endTag('div');
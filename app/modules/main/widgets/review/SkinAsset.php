<?php
namespace app\modules\main\widgets\review;

use common\components\AssetBundle;

/**
 * Class SkinAsset
 * Ассет для списка отзывов
 * @package app\modules\main\widgets\review
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class SkinAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $css = [
        'style.css',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets/skin";
        parent::init();
    }

}
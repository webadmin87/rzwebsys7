<?php
namespace app\modules\main\widgets\comments;

use yii\web\AssetBundle;

/**
 * Class SkinAsset
 * Ассет для скина виджета
 * @package app\modules\main\widgets\comments
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class SkinAsset extends AssetBundle {

    public $css = [
        'style.css',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets/skin";

    }

}
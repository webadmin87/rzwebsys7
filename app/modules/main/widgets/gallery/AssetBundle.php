<?php
namespace app\modules\main\widgets\gallery;

use yii\web\AssetBundle as YiiBundle;

/**
 * Class AssetBundle
 * Ассет для фотогаллереи
 * @package app\modules\main\widgets\gallery
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class AssetBundle extends YiiBundle {

    public $css = [
        'styles.css',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets";

    }

}
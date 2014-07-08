<?php
namespace common\widgets\markitup;

use common\components\AssetBundle;

/**
 * Class MarkItUpAsset
 * Ассет для редактора MarkItUp
 * @package common\widgets\markitup
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class MarkItUpAsset extends AssetBundle {

    public $js = [
        'jquery.markitup.js',
    ];

    public $jsMin = [
        'jquery.markitup.min.js',
    ];


    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets/markitup";

        parent::init();

    }

}
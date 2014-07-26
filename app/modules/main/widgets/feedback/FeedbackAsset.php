<?php
namespace app\modules\main\widgets\feedback;

use common\components\AssetBundle;

/**
 * Class FeedbackAsset
 * Ассет для виджета обратной связи
 * @package app\modules\main\widgets\feedback
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class FeedbackAsset extends AssetBundle {

    public $js = [
        'script.js',
    ];

    public $jsMin = [
        'script.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets";
        parent::init();
    }

}
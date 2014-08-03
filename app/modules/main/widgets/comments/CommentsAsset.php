<?php
namespace app\modules\main\widgets\comments;

use common\components\AssetBundle;

/**
 * Class CommentsAsset
 * Ассет для виджета комментариев
 * @package app\modules\main\widgets\comments
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CommentsAsset extends AssetBundle
{

    public $js = [
        'script.js',
    ];

    public $jsMin = [
        'script.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets/script";
        parent::init();
    }

}
<?php
namespace app\modules\shop\web;

use common\components\AssetBundle;

/**
 * Class ShopAsset
 * Ассет бандл интернет магазина
 * @package app\modules\shop\web
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ShopAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = "@webapp/modules/shop/assets";

    /**
     * @inheritdoc
     */
    public $js = [
        'shop.js',
        'messages.js',
        'directives.js',
        'controllers.js',
    ];

    /**
     * @inheritdoc
     */
    public $jsMin = [
        'shop.min.js',
        'messages.min.js',
        'directives.min.js',
        'controllers.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'app\modules\main\web\AngularAsset',
        'app\modules\main\web\AngularLocaleAsset',
    ];

}
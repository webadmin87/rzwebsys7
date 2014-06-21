<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * Ассет для админки
 * @package app\assets
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['css/admin.css'];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

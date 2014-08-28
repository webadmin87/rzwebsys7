<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class SwfObjectAsset
 * Ассет библиотеки swfobject
 * @package app\assets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SwfObjectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = ['js/swfobject.js'];
}

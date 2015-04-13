<?php
namespace common\web;

use common\components\AssetBundle;

/**
 * Class JqueryNumberAsset
 * Ассет дя jquery плагина форматирования чисел
 * @package common\web
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class JqueryNumberAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = ['js/jquery.number.js'];
    public $jsMin = ['js/jquery.number.min.js'];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

} 
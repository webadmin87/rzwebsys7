<?php

namespace common\widgets\yamap;

use common\components\AssetBundle;

/**
 * Class YaMapApiInput
 * Ассет подключения API яндекс карт
 * @package common\widgets\yamap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapApiAsset extends AssetBundle
{

    public $js = [
        '//api-maps.yandex.ru/2.1/?lang=ru_RU',
    ];

    public $jsMin = [
        '//api-maps.yandex.ru/2.1/?lang=ru_RU',
    ];

}
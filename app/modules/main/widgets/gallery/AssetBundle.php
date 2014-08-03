<?php
namespace app\modules\main\widgets\gallery;

use common\components\AssetBundle as BaseBundle;

/**
 * Class AssetBundle
 * Ассет для фотогаллереи
 * @package app\modules\main\widgets\gallery
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AssetBundle extends BaseBundle
{

    public $css = [
        'styles.css',
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets";
        parent::init();

    }

}
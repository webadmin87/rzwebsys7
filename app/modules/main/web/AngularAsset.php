<?php
namespace app\modules\main\web;

use common\components\AssetBundle;

/**
 * Class AngularAsset
 * Ассет бандл ангуляра
 * @package app\modules\main\web
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AngularAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = "@bower/angular";

    /**
     * @inheritdoc
     */
    public $js = ['angular.js'];

    /**
     * @inheritdoc
     */
    public $jsMin = ['angular.min.js'];

}
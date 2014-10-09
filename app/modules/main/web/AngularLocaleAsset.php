<?php
namespace app\modules\main\web;

use common\components\AssetBundle;

/**
 * Class AngularLocaleAsset
 * Ассет бандл локали ангуляра
 * @package app\modules\main\web
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AngularLocaleAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = "@bower/angular-i18n";

    /**
     * @inheritdoc
     */
    public $js = ['angular-locale_ru.js'];


}
<?php
namespace app\modules\main\sitemap;

use Yii;
use yii\base\Widget;

/**
 * Class SitemapWidget
 * Виджет отображения карты сайта
 * @package app\modules\main\sitemap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SitemapWidget extends Widget
{

    public $tpl = "sitemap";


    public function run()
    {

        return $this->render($this->tpl, ["elements"=>Yii::$app->getModule('main')->sitemap->getElements()]);

    }

}
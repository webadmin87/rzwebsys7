<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class SitemapController
 * Контроллер автоматической генерации карты сайта
 * @package console\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SitemapController extends Controller
{

    public function actionIndex()
    {

        $res = Yii::$app->getModule('main')->sitemap->renderXml();

        echo "$res items added\n";

        return 0;

    }


}
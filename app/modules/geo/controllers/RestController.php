<?php
namespace app\modules\geo\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Class RestController
 * @package app\modules\geo\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class RestController extends Controller
{

    public $streetsLimit = 50;

    /**
     * Автокомплит для улиц
     * @param string $term поисковая фраза
     * @return array
     */
    public function actionStreets($term)
    {
        return Yii::$app->getModule('geo')->suggestsFinder->streetSuggests(urldecode($term), $this->streetsLimit);
    }


}
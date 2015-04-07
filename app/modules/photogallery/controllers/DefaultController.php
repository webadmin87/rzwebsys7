<?php

namespace app\modules\photogallery\controllers;

use app\modules\photogallery\models\Gallery;
use common\cache\TagDependency;
use common\controllers\App;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * Контроллер публичной части фотогалереи
 * @package app\modules\photogallery\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DefaultController extends App
{

    const LIST_CACHE_ID = "photogallery-list";

    /**
     * @var array сортировка
     */

    public $orderBy = ["sort" => SORT_ASC, "id"=>SORT_DESC];

    /**
     * @var int количество новостей на странице
     */

    public $pageSize = 9;

    /**
     * Списочный вывод всех фотогалерей
     * @return string
     */
    public function actionIndex()
    {

        $cacheId = $this->getActionCacheId(static::LIST_CACHE_ID);

        $res = Yii::$app->cache->get($cacheId);

        if (empty($res)) {

            $model = Yii::createObject(['class' => Gallery::className()]);

            $dependency = Yii::createObject(TagDependency::className());

            $dataProvider = $model->publicSearch();

            $dataProvider->getSort()->defaultOrder = $this->orderBy;

            $dataProvider->getPagination()->pageSize = $this->pageSize;

            $dependency->addTag($model->setClassTagSafe());

            $dependency->setTagsFromModels($dataProvider->getModels());

            $res["html"] = $this->renderPartial('_grid', ["dataProvider" => $dataProvider]);

            Yii::$app->cache->set($cacheId, $res, Yii::$app->params["cacheDuration"], $dependency);

        }

        $this->view->title = Yii::t('photogallery/app', 'Photogallery');

        $this->view->addBreadCrumb(
            [
                "label"=>$this->view->title,
            ]
        );

        return $this->render("index",["html"=>$res["html"]]);

    }

    /**
     * Детальная страница фотогалереи
     * @param string $code символьный код фотогалереи
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($code)
    {
        $model = Gallery::find()->published()->andWhere(["code"=>$code])->one();

        if(!$model)
            throw new NotFoundHttpException("Gallery with code '$code' not found");

        $this->view->title = $model->title;

        $this->view->addBreadCrumbs([
            [
                "label"=>Yii::t('photogallery/app', 'Photogallery'),
                "url"=>Url::toRoute(["/photogallery/default/index"])
            ],
            [
                "label"=>$model->title,
            ]
        ]);

        return $this->render("detail", ["model"=>$model]);

    }

}

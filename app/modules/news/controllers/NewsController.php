<?php

namespace app\modules\news\controllers;

use app\modules\news\models\News;
use app\modules\news\models\NewsSection;
use common\cache\TagDependency;
use common\controllers\App;
use common\db\ActiveRecord;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * Контроллер отображения новостей
 * @package app\modules\news\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NewsController extends App
{

    const LIST_CACHE_ID = "news-list";

    /**
     * @var array сортировка новостей
     */

    public $orderBy = ["id" => SORT_DESC];

    /**
     * @var int количество новостей на странице
     */

    public $pageSize = 10;

    /**
     * @var int ширина детального изображения
     */

    public $detailImageWidth = 240;

    /**
     * @var int ширина списочного изображения
     */

    public $previewImageWidth = 120;

    /**
     * Списочный вывод новостей
     * @param null|string $section символьный код категории новости
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionIndex($section = null)
    {

        $cacheId = $this->getActionCacheId(static::LIST_CACHE_ID);

        $res = Yii::$app->cache->get($cacheId);

        if (empty($res)) {

            $dependency = Yii::createObject(TagDependency::className());

            $model = Yii::createObject(['class' => News::className(), 'scenario' => ActiveRecord::SCENARIO_SEARCH]);

            $res["sectionModel"] = null;

            $ids = null;

            if ($section) {

                $res["sectionModel"] = NewsSection::find()->published()->andWhere(["code" => $section])->one();

                if (!$res["sectionModel"])
                    throw new NotFoundHttpException;

                $ids = $res["sectionModel"]->getFilterIds();

            }

            $dataProvider = $model->searchBySection($ids);

            $dataProvider->getSort()->defaultOrder = $this->orderBy;

            $dataProvider->getPagination()->pageSize = $this->pageSize;

            $dependency->setTagsFromModels($dataProvider->getModels());

            $res["html"] = $this->renderPartial('index', ["dataProvider" => $dataProvider, "sectionModel" => $res["sectionModel"], "previewImageWidth" => $this->previewImageWidth]);

            Yii::$app->cache->set($cacheId, $res, Yii::$app->params["cacheDuration"], $dependency);

        }


        if ($res["sectionModel"]) {
            $this->view->registerMetaTags($res["sectionModel"]);

            $crumbs = $res["sectionModel"]->getBreadCrumbsItems($res["sectionModel"]->id, function ($model) {
                return ['/news/news/index', 'section' => $model->code];
            });

            $this->view->addBreadCrumbs($crumbs);
        } else {
            $this->view->addBreadCrumb(
                [
                    "label"=>Yii::t('news/app', 'News'),
                    "url"=>Url::toRoute(["/news/news/index"])
                ]
            );
        }

        return $this->renderHtml($res["html"]);

    }

    /**
     * Отображение детальной новости
     * @param string $code символьный идентификатор новости
     * @param string $section символьный идентификатор категории новости
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionDetail($code, $section)
    {

        $model = News::find()->published()->andWhere(["code" => $code])->one();

        if (!$model)
            throw new NotFoundHttpException;

        $sectionModel = NewsSection::find()->published()->andWhere(["code" => $section])->one();

        $this->view->addBreadCrumbs(
            $sectionModel->getBreadCrumbsItems($sectionModel, function ($model) {
                return ['/news/news/index', 'section' => $model->code];
            })
        );

        $this->view->addBreadCrumb([
            "label"=>$model->title,
            "url"=>Url::toRoute(["/news/news/detail", "code"=>$code, "section"=>$section]),
        ]);

        $this->view->registerMetaTags($model);

        return $this->render('detail', ["model" => $model, "detailImageWidth" => $this->detailImageWidth]);

    }

}
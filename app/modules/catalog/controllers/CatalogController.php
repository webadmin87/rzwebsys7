<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\Catalog;
use app\modules\catalog\models\CatalogSection;
use common\cache\TagDependency;
use common\controllers\App;
use common\db\ActiveRecord;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class CatalogController
 * Контроллер отображения каталога
 * @package app\modules\catalog\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogController extends App
{

    const LIST_CACHE_ID = "catalog-list";

    /**
     * @var array сортировка
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
     * Списочный вывод каталога
     * @param null|string $section символьный код категории каталога
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionIndex($section = null)
    {

        $cacheId = $this->getActionCacheId(static::LIST_CACHE_ID);

        $res = Yii::$app->cache->get($cacheId);

        $model = Yii::createObject(['class' => Catalog::className(), 'scenario' => ActiveRecord::SCENARIO_SEARCH]);

        $model->load(Yii::$app->request->get());

        if (empty($res)) {

            $dependency = Yii::createObject(TagDependency::className());

            $res["sectionModel"] = null;

            if (empty($model->sectionsIds) AND $section) {

                $res["sectionModel"] = CatalogSection::find()->published()->andWhere(["code" => $section])->one();

                if (!$res["sectionModel"])
                    throw new NotFoundHttpException;

                $model->sectionsIds = $res["sectionModel"]->getFilterIds();

            }

            $dataProvider = \Yii::$app->getModule('catalog')->filterProvider->getDataProvider($model);

            $dataProvider->getSort()->defaultOrder = $this->orderBy;

            $dataProvider->getPagination()->pageSize = $this->pageSize;

            $dependency->addTag($model->setClassTag());

            $dependency->setTagsFromModels($dataProvider->getModels());

            $res["html"] = $this->renderPartial('_grid', ["dataProvider" => $dataProvider, "previewImageWidth" => $this->previewImageWidth]);

            Yii::$app->cache->set($cacheId, $res, Yii::$app->params["cacheDuration"], $dependency);

        }

        $this->view->addBreadCrumb(
            [
                "label"=>Yii::t('catalog/app', 'Catalog'),
                "url"=>Url::toRoute(["/catalog/catalog/index"])
            ]
        );


        if ($res["sectionModel"]) {
            $this->view->registerMetaTags($res["sectionModel"]);

            $crumbs = $res["sectionModel"]->getBreadCrumbsItems($res["sectionModel"]->id, function ($model) {
                return ['/catalog/catalog/index', 'section' => $model->code];
            });

            $this->view->addBreadCrumbs($crumbs);
        }

        return $this->render("index",["sectionModel" => $res["sectionModel"], "model"=>$model, "html"=>$res["html"]]);

    }

    /**
     * Отображение карточки элемента каталога
     * @param string $code символьный идентификатор элемента каталога
     * @param string $section символьный идентификатор категории каталога
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionDetail($code, $section)
    {

        $model = Catalog::find()->published()->andWhere(["code" => $code])->one();

        if (!$model)
            throw new NotFoundHttpException;

        $sectionModel = CatalogSection::find()->published()->andWhere(["code" => $section])->one();

        $this->view->addBreadCrumbs(
            $sectionModel->getBreadCrumbsItems($sectionModel, function ($model) {
                return ['/catalog/catalog/index', 'section' => $model->code];
            })
        );

        $this->view->addBreadCrumb([
            "label"=>$model->title,
            "url"=>Url::toRoute(["/catalog/catalog/detail", "code"=>$code, "section"=>$section]),
        ]);

        $this->view->registerMetaTags($model);

        return $this->render('detail', ["model" => $model, "detailImageWidth" => $this->detailImageWidth]);

    }

}
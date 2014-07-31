<?php

namespace app\modules\news\controllers;

use Yii;
use common\db\ActiveRecord;
use common\controllers\App;
use app\modules\news\models\News;
use app\modules\news\models\NewsSection;
use yii\web\NotFoundHttpException;
use \common\cache\TagDependency;
/**
 * Class NewsController
 * Контроллер отображения новостей
 * @package app\modules\news\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class NewsController extends App {

    /**
     * @var array сортировка новостей
     */

    public $orderBy = ["id"=>SORT_DESC];

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

    public function actionIndex($section = null) {

        $cacheId = ["news-list", Yii::$app->request->url];

        $res = Yii::$app->cache->get($cacheId);

        if(empty($res)) {

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

        if($res["sectionModel"])
            $this->view->registerMetaTags($res["sectionModel"]);

        return $this->renderHtml($res["html"]);

    }

    /**
     * Отображение детальной новости
     * @param string $code символьный идентификатор новости
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionDetail($code) {

        $model = News::find()->published()->andWhere(["code"=>$code])->one();

        if(!$model)
            throw new NotFoundHttpException;

        $this->view->registerMetaTags($model);

        return $this->render('detail', ["model"=>$model, "detailImageWidth"=>$this->detailImageWidth]);

    }


}
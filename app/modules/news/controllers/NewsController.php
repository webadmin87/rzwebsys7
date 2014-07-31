<?php

namespace app\modules\news\controllers;

use Yii;
use common\db\ActiveRecord;
use common\controllers\App;
use app\modules\news\models\News;
use app\modules\news\models\NewsSection;
use yii\web\NotFoundHttpException;
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

        $model = Yii::createObject(['class'=>News::className(), 'scenario'=>ActiveRecord::SCENARIO_SEARCH]);

        $sectionModel = null;

        $ids = null;

        if($section) {

            $sectionModel = NewsSection::find()->published()->andWhere(["code"=>$section])->one();

            if(!$sectionModel)
                throw new NotFoundHttpException;

            $ids = $sectionModel->getFilterIds();

        }

        $dataProvider = $model->searchBySection($ids);

        $dataProvider->getSort()->defaultOrder = $this->orderBy;

        $dataProvider->getPagination()->pageSize = $this->pageSize;

        return $this->render('index', ["dataProvider"=>$dataProvider, "sectionModel"=>$sectionModel, "previewImageWidth"=>$this->previewImageWidth]);

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

        return $this->render('detail', ["model"=>$model, "detailImageWidth"=>$this->detailImageWidth]);

    }


}
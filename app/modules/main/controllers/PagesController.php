<?php

namespace app\modules\main\controllers;

use app\modules\main\models\Pages;
use common\controllers\App;
use common\db\TActiveRecord;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

/**
 * Class PagesController
 * Контроллер отображения текстовых страниц
 * @package app\modules\main\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PagesController extends App
{

    /**
     * @var array массив индексов в которых необходимо производить поиск
     */
    public $searchIndexes = ['rzwebsys7CatalogIndex', 'rzwebsys7NewsIndex', 'rzwebsys7PagesIndex'];

    /**
     * Отображение текстовой страницы
     * @param Pages|boolean $model модель страницы
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionIndex($model = false)
    {

        if($model === false)
            $model = Pages::findOne(TActiveRecord::ROOT_ID)->children(1)->andWhere(["code"=>Pages::INDEX_CODE])->one();

        if (!$model)
            throw new NotFoundHttpException;

        if ($model->code != Pages::INDEX_CODE)
            $this->view->breadCrumbs = $model->getBreadCrumbsItems($model->id, function ($model) {
                return ['/main/pages/index', 'model' => $model];
            });

        $this->view->registerMetaTags($model);

        return $this->render('index', ["model" => $model]);

    }

    /**
     * Страница поиска через сфинкс
     * @param string $term потсковая фраза
     * @return string
     */
    public function actionSearch($term)
    {

        $query = \Yii::createObject(\yii\sphinx\Query::className());

        $query->from($this->searchIndexes)->match(Html::encode($term));

        $dataProvider = \Yii::createObject([

            "class"=>\yii\data\ActiveDataProvider::className(),
            "query"=>$query,
        ]);

        return $this->render("search", ["term"=>Html::encode($term), "dataProvider"=>$dataProvider]);

    }


}
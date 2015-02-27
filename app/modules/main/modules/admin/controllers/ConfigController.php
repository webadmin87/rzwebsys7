<?php
namespace app\modules\main\modules\admin\controllers;

use app\modules\main\models\Config;
use common\controllers\Root;
use common\db\ActiveRecord;
use Yii;
use yii\base\Model;
use common\actions\crud;

/**
 * Class ConfigController
 * Контроллер конфига
 * @package app\modules\admin\controllers
 */
class ConfigController extends Root
{

    /**
     * @var string идентификатор файла перевода
     */

    public $tFile = "main/app";

    /**
     * Действия
     * @return array
     */
    public function actions()
    {

        $class = Config::className();

        return [

            'create' => [
                'class' => crud\Create::className(),
                'modelClass' => $class,
            ],

            'update' => [
                'class' => crud\Update::className(),
                'modelClass' => $class,
            ],

            'delete' => [
                'class' => crud\Delete::className(),
                'modelClass' => $class,
            ],

        ];

    }

    /**
     * Отображение и сохранение конфигурации
     * @return string|\yii\web\Response
     */

    public function actionIndex()
    {

        $searchModel = new Config(["scenario"=>ActiveRecord::SCENARIO_SEARCH]);

        $models = Config::find()->orderBy(["id" => SORT_DESC])->all();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            foreach ($models as $setting) {
                $setting->save(false);
            }

            return $this->refresh();
        }

        return $this->render('index', ['models' => $models, "searchModel"=>$searchModel]);

    }

}
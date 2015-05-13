<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 13.05.15
 * Time: 12:40
 */

namespace app\modules\import\modules\admin\controllers;

use app\modules\import\models\CsvModel;
use common\controllers\Admin;


/**
 * Class CsvImportController
 * Контроллер импорта моделей из CSV файл
 * @package app\modules\import\modules\admin\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CsvImportController extends Admin
{

    public $sessionKey = "csvImportModel";

    /**
     * Первый шаг импорта
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {

        $model = \Yii::$app->session->get($this->sessionKey);

        if(!$model)
            $model = new CsvModel();

        if(\Yii::$app->request->isPost) {

            $load = $model->load(\Yii::$app->request->post());

            if($load AND $model->validate()) {

                \Yii::$app->session->set($this->sessionKey, $model);

                return $this->redirect(['/import/admin/csv-import/import/']);

            }

        }

        $classes = \Yii::$app->getModule('import')->csvImporter->allowedModels;

        return $this->render("index", ["model"=>$model, "classes"=>$classes]);

    }

    /**
     * Завершающий шаг импорта
     * @return string
     */
    public function actionImport()
    {

        $model = \Yii::$app->session->get($this->sessionKey);

        if(!$model)
            return $this->redirect(['/import/admin/csv-import/index/']);

        if(\Yii::$app->request->isPost) {

            $load = $model->load(\Yii::$app->request->post());

            $model->setScenario(CsvModel::SCENARIO_COMPLETE);

            if($load AND $model->validate()) {

                $res = \Yii::$app->getModule('import')->csvImporter->import($model);

                if($res)
                    \Yii::$app->session->remove($this->sessionKey);

                return $this->render("result", ["res"=>$res]);


            } else {

                $model->setScenario(CsvModel::SCENARIO_DEFAULT);

            }

        }

        if(empty($model->mapping))
            $model->loadMapping();

        $importModel = $model->createImportModel();

        return $this->render('import', ["model"=>$model, "importModel"=>$importModel]);


    }

} 
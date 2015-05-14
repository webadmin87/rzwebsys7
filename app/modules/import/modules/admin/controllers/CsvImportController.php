<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 13.05.15
 * Time: 12:40
 */

namespace app\modules\import\modules\admin\controllers;

use app\modules\import\models\CsvModel;
use common\controllers\Root;
use Yii;
use yii\helpers\Html;

/**
 * Class CsvImportController
 * Контроллер импорта моделей из CSV файл
 * @package app\modules\import\modules\admin\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CsvImportController extends Root
{

    public $sessionKey = "csvImportModel";

    /**
     * Первый шаг импорта
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {

        $model = Yii::$app->session->get($this->sessionKey);

        if(!$model)
            $model = new CsvModel();

        if(Yii::$app->request->isPost) {

            $load = $model->load(Yii::$app->request->post());

            if($load AND $model->validate()) {

                Yii::$app->session->set($this->sessionKey, $model);

                return $this->redirect(['/import/admin/csv-import/import/']);

            }

        }

        $classes = Yii::$app->getModule('import')->csvImporter->getClasses();

        return $this->render("index", ["model"=>$model, "classes"=>$classes]);

    }

    /**
     * Завершающий шаг импорта
     * @return string
     */
    public function actionImport()
    {

        set_time_limit(0);

        $model = Yii::$app->session->get($this->sessionKey);

        if(!$model)
            return $this->redirect(['/import/admin/csv-import/index/']);

        $importer = Yii::$app->getModule('import')->csvImporter;

        if(Yii::$app->request->isPost) {

            $load = $model->load(Yii::$app->request->post());

            $model->setScenario(CsvModel::SCENARIO_COMPLETE);

            if($load AND $model->validate()) {

                $res = $importer->import($model);

                if($res)
                    Yii::$app->session->remove($this->sessionKey);

                return $this->render("result", ["res"=>$res]);


            } else {

                $model->setScenario(CsvModel::SCENARIO_DEFAULT);

            }

        }

        if(empty($model->mapping))
            $model->loadMapping();

        $importModel = $importer->createImportModel($model->modelClass);

        return $this->render('import', ["model"=>$model, "importModel"=>$importModel]);


    }

    /**
     * Зависимый список атрибутов модели
     * @param string $cls класс
     */
    public function actionKeys($cls)
    {
        $attrs = Yii::$app->getModule('import')->csvImporter->getCsvAttributes($cls);

        foreach($attrs AS $k => $v) {

            echo Html::tag('option', $v, ['value'=>$k]);

        }
    }

} 
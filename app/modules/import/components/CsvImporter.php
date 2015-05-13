<?php

namespace app\modules\import\components;

use app\modules\import\models\CsvModel;
use common\db\ActiveRecord;
use yii\base\Object;

/**
 * Class CsvImporter
 * Компонент импорта данных из csv файла
 * @package app\modules\import\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CsvImporter extends Object
{

    /**
     * @var array массив классов моделей доступных для импорта
     */
    public $allowedModels = [];


    /**
     * Импорт содержимого CSV файла
     * @param CsvModel $model
     * @return bool|array
     */
    public function import(CsvModel $model)
    {

        if(!$model->validate())
            return false;

        if (($handle = $model->openFile()) !== false) {

            $errors = 0;

            $ok = 0;

            $i = 0;

            while (($data = $model->readLine($handle)) !== false) {

                $i++;

                if($i==1 AND $model->headLine)
                    continue;

                $cls = $model->modelClass;

                $key = $model->key;

                if(isset($model->mapping[$key]) AND !empty($data[$model->mapping[$key]])) {

                    $importModel = $cls::findOne([$key=>$data[$model->mapping[$key]]]);

                }

                if(empty($importModel))
                    $importModel = $model->createImportModel(["scenario"=>ActiveRecord::SCENARIO_INSERT]);

                foreach($model->mapping AS $attr => $index) {

                    if(!is_numeric($index))
                        continue;

                    if($key == 'id' AND $attr == $key)
                        continue;

                    $val = isset($data[$index])?$data[$index]:null;

                    $val = $this->isJson($val)?json_decode($val):$val;

                    $importModel->$attr = $val;

                }


                if($importModel->save())
                    $ok++;
                else
                    $errors++;

                unset($importModel);

            }

            $model->closeFile($handle);

            return ["ok"=>$ok, "errors"=>$errors];

        }

        return false;

    }

    public function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

} 
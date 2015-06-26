<?php

namespace app\modules\import\components;

use app\modules\import\models\CsvModel;
use app\modules\import\models\ICsvImportable;
use common\db\ActiveRecord;
use yii\base\ErrorException;
use yii\base\Object;
use yii\helpers\ArrayHelper;

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
                    $importModel = $this->createImportModel($cls, ["scenario"=>ActiveRecord::SCENARIO_INSERT]);

                foreach($model->mapping AS $attr => $index) {

                    if(!is_numeric($index))
                        continue;

                    if($key == 'id' AND $attr == $key)
                        continue;

                    $val = isset($data[$index])?$data[$index]:null;

                    $val = $this->isJson($val)?json_decode($val):$val;

                    $importModel->$attr = $val;

                }

                if(!$model->validate AND $importModel->hasAttribute('active')) {
                    $importModel->active=false;
                }

                if($importModel->save($model->validate))
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

    /**
     * Является ли строка валидным json
     * @param $string
     * @return bool
     */
    public function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Создает экземпляр импортируемой модели
     * @param string $cls класс модели
     * @param array $config
     * @return \yii\db\ActiveRecord
     * @throws ErrorException
     */
    public function createImportModel($cls, $config=[])
    {

        $importModel = new $cls($config);

        if(! $importModel instanceof ICsvImportable)
            throw new ErrorException(get_class($importModel) . ' does not implement \app\modules\import\models\ICsvImportable');

        return $importModel;

    }

    /**
     * Возвращает массив названий атрибутов доступных для csv импорта
     * @param string $cls класс импортируемой модели
     * @return array
     * @throws ErrorException
     */
    public function getCsvAttributes($cls)
    {

        $importModel = $this->createImportModel($cls);

        $attrs = $importModel->getCsvAttributes();

        $arr = [];

        foreach($attrs as $attr) {

            $arr[$attr] = $importModel->getAttributeLabel($attr);

        }

        return $arr;

    }

    /**
     * Возвращает массив имен доступных классов
     * @return array
     */
    public function getClasses()
    {
        $arr = ArrayHelper::map($this->allowedModels, function($data){
            return $data;
        }, function($data){
            return $data::getEntityName();
        });

        return $arr;

    }


} 
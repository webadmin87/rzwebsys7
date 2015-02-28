<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Html;

/**
 * Class Upload
 * Действие загрузки файлов
 * @package common\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Upload extends Action
{

    /**
     * Загружает файлы
     * @param string $model клысс модели
     * @param string $attr атрибут модели
     * @return string
     */

    public function run($model, $attr)
    {

        $item = Yii::createObject($model);

        $name = Html::getInputName($item, $attr);

        $files = $item->uploadFiles($name);

        $res = array_shift($files);

        Yii::$app->getResponse()->setStatusCode(200);

        return $res;

    }

}
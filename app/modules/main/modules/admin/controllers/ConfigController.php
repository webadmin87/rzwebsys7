<?php
namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\Config;
use common\controllers\Admin;
use yii\base\Model;

/**
 * Class ConfigController
 * Контроллер конфига
 * @package app\modules\admin\controllers
 */
class ConfigController extends Admin
{

    /**
     * Отображение и сохранение конфигурации
     * @return string|\yii\web\Response
     */

    public function actionIndex()
    {

        $models = Config::find()->orderBy(["id" => SORT_DESC])->all();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            foreach ($models as $setting) {
                $setting->save(false);
            }

            return $this->refresh();
        }

        return $this->render('index', ['models' => $models]);

    }


}
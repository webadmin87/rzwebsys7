<?php
namespace app\modules\main\modules\admin\controllers;

use app\modules\main\models\User;
use common\controllers\Root;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Class ToolsController
 * Контроллер различных административный действий
 * @package app\modules\main\modules\admin\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ToolsController extends Root
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $beh = parent::behaviors();

        $beh['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
            'except' => ['index'],
        ];

        return $beh;

    }

    /**
     * Вывод интерфейса
     * @return string
     */

    public function actionIndex()
    {

        return $this->render("index");

    }

    /**
     * Установка ролей
     */

    public function actionRbac()
    {

        $installer = Yii::$app->rbacInstaller;

        $installer->install();

        $installer->assign();

        return ["page" => 1, "pagesNum" => 1];

    }

    /**
     * Очистка кеша
     * @return array
     */

    public function actionClearCache()
    {

        Yii::$app->cache->flush();

        return ["page" => 1, "pagesNum" => 1];

    }

}
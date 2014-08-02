<?php
namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\User;
use common\controllers\Root;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\Controller;
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
            'except'=>['index'],
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

        $installer = Yii::createObject(\app\modules\main\rbac\Installer::className());

        $installer->install();

        $auth = Yii::$app->authManager;

        $config = array_merge([
            'class' => ActiveDataProvider::className(),
            "query" => User::find(),
        ]);

        $dataProvider = Yii::createObject($config);

        $pager = $dataProvider->getPagination();

        foreach ($dataProvider->getModels() AS $model) {

            $r = $model->role;

            if ($r)
                $auth->assign($auth->getRole($r), $model->id);

        }

        return ["page" => $pager->page+1, "pagesNum" => $pager->pageCount];

    }

    /**
     * Очистка кеша
     * @return array
     */

    public function actionClearCache() {

        Yii::$app->cache->flush();

        return ["page" => 1, "pagesNum" => 1];

    }

}
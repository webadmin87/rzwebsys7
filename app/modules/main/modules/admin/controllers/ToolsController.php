<?php
namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\User;
use common\controllers\Admin;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Class ToolsController
 * Контроллер различных административный действий
 * @package app\modules\main\modules\admin\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ToolsController extends Admin
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

        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $accessAdmin = $auth->createPermission('accessAdmin');
        $accessAdmin->description = 'access admin panel';
        $auth->add($accessAdmin);

        $createModel = $auth->createPermission('createModel');
        $createModel->description = 'create model';
        $auth->add($createModel);

        $readModel = $auth->createPermission('readModel');
        $readModel->description = 'read model';
        $auth->add($readModel);

        $updateModel = $auth->createPermission('updateModel');
        $updateModel->description = 'update model';
        $auth->add($updateModel);

        $deleteModel = $auth->createPermission('deleteModel');
        $deleteModel->description = 'delete model';
        $auth->add($deleteModel);

        $listModels = $auth->createPermission('listModel');
        $listModels->description = 'list models';
        $auth->add($listModels);

        // root role

        $root = $auth->createRole('root');
        $auth->add($root);
        $auth->addChild($root, $accessAdmin);
        $auth->addChild($root, $createModel);
        $auth->addChild($root, $readModel);
        $auth->addChild($root, $updateModel);
        $auth->addChild($root, $deleteModel);
        $auth->addChild($root, $listModels);

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
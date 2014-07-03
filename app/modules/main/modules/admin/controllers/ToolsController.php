<?php
namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\User;
use common\controllers\Admin;
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
        $accessAdmin->description = 'access to admin panel';
        $auth->add($accessAdmin);

        $rootAccess = $auth->createPermission('rootAccess');
        $rootAccess->description = 'root access to admin panel';
        $auth->add($rootAccess);

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

        $listModels = $auth->createPermission('listModels');
        $listModels->description = 'list models';
        $auth->add($listModels);

        // rules

        $createRule = new \app\modules\main\rbac\CreateRule;
        $auth->add($createRule);

        $createModelRule = $auth->createPermission('createModelRule');
        $createModelRule->description = 'create model';
        $createModelRule->ruleName = $createRule->name;
        $auth->add($createModelRule);
        $auth->addChild($createModelRule, $createModel);

        $readRule = new \app\modules\main\rbac\ReadRule;
        $auth->add($readRule);

        $readModelRule = $auth->createPermission('readModelRule');
        $readModelRule->description = 'read model';
        $readModelRule->ruleName = $readRule->name;
        $auth->add($readModelRule);
        $auth->addChild($readModelRule, $readModel);

        $updateRule = new \app\modules\main\rbac\UpdateRule;
        $auth->add($updateRule);

        $updateModelRule = $auth->createPermission('updateModelRule');
        $updateModelRule->description = 'update model';
        $updateModelRule->ruleName = $updateRule->name;
        $auth->add($updateModelRule);
        $auth->addChild($updateModelRule, $updateModel);

        $deleteRule = new \app\modules\main\rbac\DeleteRule;
        $auth->add($deleteRule);

        $deleteModelRule = $auth->createPermission('deleteModelRule');
        $deleteModelRule->description = 'delete model';
        $deleteModelRule->ruleName = $deleteRule->name;
        $auth->add($deleteModelRule);
        $auth->addChild($deleteModelRule, $deleteModel);

        $listRule = new \app\modules\main\rbac\ListRule;
        $auth->add($listRule);

        $listModelsRule = $auth->createPermission('listModelsRule');
        $listModelsRule->description = 'list models';
        $listModelsRule->ruleName = $listRule->name;
        $auth->add($listModelsRule);
        $auth->addChild($listModelsRule, $listModels);

        // user role

        $user = $auth->createRole('user');
        $auth->add($user);

        // manager role

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $accessAdmin);
        $auth->addChild($manager, $listModelsRule);
        $auth->addChild($manager, $createModelRule);
        $auth->addChild($manager, $readModelRule);
        $auth->addChild($manager, $updateModelRule);
        $auth->addChild($manager, $deleteModelRule);

        // admin role

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $createModel);
        $auth->addChild($admin, $readModel);
        $auth->addChild($admin, $updateModel);
        $auth->addChild($admin, $deleteModel);
        $auth->addChild($admin, $listModels);

        // root role

        $root = $auth->createRole('root');
        $auth->add($root);
        $auth->addChild($root, $admin);
        $auth->addChild($root, $rootAccess);


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
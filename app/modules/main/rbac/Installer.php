<?php

namespace app\modules\main\rbac;

use app\modules\main\models\User;
use Yii;
use yii\base\Object;

/**
 * Class Installer
 * Установщик ролей
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Installer extends Object
{

    /**
     * Установка ролей
     */

    public function install()
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

        $user = $auth->createRole(User::ROLE_USER);
        $auth->add($user);

        // admin role

        $admin = $auth->createRole(User::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $accessAdmin);
        $auth->addChild($admin, $listModelsRule);
        $auth->addChild($admin, $createModelRule);
        $auth->addChild($admin, $readModelRule);
        $auth->addChild($admin, $updateModelRule);
        $auth->addChild($admin, $deleteModelRule);

        // admin role

        /*$admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $createModel);
        $auth->addChild($admin, $readModel);
        $auth->addChild($admin, $updateModel);
        $auth->addChild($admin, $deleteModel);
        $auth->addChild($admin, $listModels);*/

        // root role

        $root = $auth->createRole(USER::ROLE_ROOT);
        $auth->add($root);
        $auth->addChild($root, $admin);
        $auth->addChild($root, $rootAccess);
        $auth->addChild($root, $createModel);
        $auth->addChild($root, $readModel);
        $auth->addChild($root, $updateModel);
        $auth->addChild($root, $deleteModel);
        $auth->addChild($root, $listModels);

    }

}
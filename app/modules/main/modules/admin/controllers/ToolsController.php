<?php
namespace app\modules\main\modules\admin\controllers;

use Yii;

use yii\web\Controller;

class ToolsController extends Controller {


    public function actionRbac() {


        $auth = Yii::$app->authManager;

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
        $auth->addChild($root, $createModel);
        $auth->addChild($root, $readModel);
        $auth->addChild($root, $updateModel);
        $auth->addChild($root, $deleteModel);
        $auth->addChild($root, $listModels);


    }

}
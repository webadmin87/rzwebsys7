<?php
namespace console\controllers;

use Yii;
use app\modules\main\models\User;
use yii\console\Controller;

/**
 * Class InstallController
 * Контроллнр установки системы
 * @package console\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class InstallController extends Controller {

    /**
     * Установка системы
     * @return int
     */

    public function actionIndex() {

        $this->installRoles();

        return 0;

    }

    /**
     * Установка ролей
     * @throws \yii\base\InvalidConfigException
     */

    protected function installRoles() {

        $installer = Yii::createObject(\app\modules\main\rbac\Installer::className());

        $installer->install();

        $auth = Yii::$app->authManager;

        $iterator = User::find()->each();

        foreach($iterator AS $model) {

            $r = $model->role;

            if ($r)
                $auth->assign($auth->getRole($r), $model->id);

        }


    }

}
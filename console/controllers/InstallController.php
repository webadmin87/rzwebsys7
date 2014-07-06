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

    const MIGRATE_ID = "migrate";

    /**
     * Установка системы
     * @return int
     */

    public function actionIndex() {

        echo Yii::t('main/app', 'Apply migrations...') . "\n";

        $migrate = $controller = Yii::createObject([
            "class"=>Yii::$app->controllerMap[self::MIGRATE_ID],
            "db"=>Yii::$app->db,
            "migrationPath"=>Yii::getAlias('@console/migrations'),
        ], [self::MIGRATE_ID, Yii::$app]);

        $migrate->actionUp();

        $this->actionRoles();

        echo Yii::t('main/app', 'Install complete!') . "\n";

        return 0;

    }

    /**
     * Установка ролей
     * @throws \yii\base\InvalidConfigException
     */

    protected function actionRoles() {

        echo Yii::t('main/app', 'Installing roles...') . "\n";

        $installer = Yii::createObject(\app\modules\main\rbac\Installer::className());

        $installer->install();

        $auth = Yii::$app->authManager;

        $iterator = User::find()->each();

        foreach($iterator AS $model) {

            $r = $model->role;

            if ($r)
                $auth->assign($auth->getRole($r), $model->id);

        }

        return 0;

    }

}
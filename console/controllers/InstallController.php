<?php

namespace console\controllers;

use Yii;
use app\modules\main\models\User;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class InstallController
 * Контроллнр установки системы
 * @package console\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class InstallController extends Controller
{

    const MIGRATE_ID = "migrate";

    /**
     * Установка системы
     * @return int
     */
    public function actionIndex()
    {

        $this->stdout(Yii::t('main/app', "Start installing")."...\n", Console::BOLD);

        $this->actionMigrate();

        $this->actionRoles();

        $this->actionPassword();

        $this->stdout(Yii::t('main/app', "Install complete")."!\n", Console::BOLD);

        return 0;

    }

    /**
     * Применение миграций
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMigrate()
    {

        $this->stdout(Yii::t('main/app', "Apply migrations")."...\n");

        $migrate = Yii::createObject(
            array_merge(
                Yii::$app->controllerMap[self::MIGRATE_ID],
                [
                    "db"=>Yii::$app->db,
                ]
            ),
            [self::MIGRATE_ID, Yii::$app]);

        $migrate->actionUp();

        return 0;

    }

    /**
     * Установка ролей
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRoles()
    {

        $this->stdout(Yii::t('main/app', "Installing roles")."...\n");

        $installer = Yii::$app->rbacInstaller;

        $installer->install();

        $installer->assign();

        return 0;

    }

    /**
     * Задание пароля суперпользователя
     */
    public function actionPassword()
    {
        do {
            $pass = $this->prompt(Yii::t('main/app', 'Input root password:'), ["required" => true]);

            $confPass = $this->prompt(Yii::t('main/app', 'Confirm root password:'), ["required" => true]);

            $user = User::findOne(["username" => "root"]);

            $user->password = $pass;

            $user->confirm_password = $confPass;

            $res = $user->save();

            if(!$res) {

                foreach($user->getErrors() AS $errorArr) {

                    foreach($errorArr AS $error)
                        $this->stdout($error."\n", Console::FG_RED);

                }


            }

        } while (!$res);

        return 0;

    }




}
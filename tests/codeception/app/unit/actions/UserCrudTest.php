<?php
namespace tests\codeception\app\unit\actions;

use app\modules\main\models\User;
use Yii;
use Codeception\Specify;
use tests\codeception\app\unit\CrudTestCase;
use tests\codeception\common\fixtures\UserFixture;
use yii\helpers\ArrayHelper;

/**
 * Class UserCrudTest
 * Тест Crud пользователей
 * @package tests\codeception\app\unit\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class UserCrudTest extends CrudTestCase
{

    public $indexRoute = "/main/admin/user/index";

    public $createRoute = "/main/admin/user/create";

    public $updateRoute = "/main/admin/user/update";

    public $deleteRoute = "/main/admin/user/delete";

    public $groupDeleteRoute = "/main/admin/user/groupdelete";

    public $viewRoute = "/main/admin/user/view";

    /**
     * Тест списка моделей
     */
    public function testAdminUser()
    {

        $route = $this->indexRoute;

        $this->getRequest($route);

        $res = Yii::$app->runAction($route);

        $this->specify('action result is text', function () use ($res) {

            $this->assertTrue(strlen($res)>0);

        });

    }


    /**
     * Тест создания пользователя
     */
    public function testCreateUser()
    {

        $route = $this->createRoute;

        $this->postRequest($route);

        $_POST = [

            'User'=>[
                'username' => 'admin',
                'email' => 'admin@test.ru',
                'password' => 'test-password',
                'confirm_password' => 'test-password',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'role' => 'root',
            ]
        ];

        $res = Yii::$app->runAction($route);

        $model = User::findOne(["username"=>"admin"]);

        $this->specify('user must be created', function () use ($model, $res) {

            expect("model exists in database",!empty($model))->true();
            expect("action return object", is_object($res))->true();

        });

    }

    /**
     * Тест изменения пользователя
     */
    public function testUpdateUser()
    {

        $model = User::findOne(["username"=>"root"]);

        $route = $this->updateRoute;

        $this->postRequest([$route, "id"=>$model->id]);

        $newEmail = 'new@email.ru';

        $_POST = [

            'User'=>[
                'email'=>$newEmail,
            ]
        ];

        Yii::$app->runAction($route, ["id"=>$model->id]);

        $model->refresh();

        $this->specify('user must be updated', function () use ($model, $newEmail) {

            $this->assertTrue($model->email==$newEmail);

        });

    }

    /**
     * Тест удаления пользователя
     */
    public function testDeleteUser()
    {

        $model = User::findOne(["username"=>"naumov.vil"]);

        $route = $this->deleteRoute;

        $this->postRequest([$route, "id"=>$model->id]);

        Yii::$app->runAction($route, ["id"=>$model->id]);

        $model = User::findOne(["username"=>"naumov.vil"]);

        $this->specify('user does not exists', function () use ($model) {

            $this->assertTrue($model===null);

        });

    }

    /**
     * Тест группового удаления пользователей
     */
    public function testGroupDeleteUser()
    {

        $models = User::find()->all();

        $route = $this->groupDeleteRoute;

        $this->postRequest($route);

        $_POST = [
            "selection"=>array_keys(ArrayHelper::map($models, "id", "id")),
        ];

        Yii::$app->runAction($route);

        $count =  User::find()->count();

        $this->specify('all users was deleted', function () use ($count) {

            $this->assertTrue($count==0);

        });

    }

    /**
     * Тест просмотра пользователя
     */
    public function testViewUser()
    {

        $model = User::findOne(["username" => "root"]);

        $route = $this->viewRoute;

        $this->getRequest([$route, "id"=>$model->id]);

        $res = Yii::$app->runAction($route, ["id" => $model->id]);

        $this->specify('action result is text', function () use ($res) {

            $this->assertTrue(strlen($res)>0);

        });

    }


    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/common/fixtures/data/user.php'
            ],
        ];
    }


}
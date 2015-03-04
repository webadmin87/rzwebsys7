<?php
namespace tests\codeception\app\unit\actions;

use app\modules\main\models\Pages;
use common\db\TActiveRecord;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\PagesFixture;
use Yii;
use tests\codeception\app\unit\CrudTestCase;
use app\modules\main\modules\admin;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class PageCrudTest
 * Тест CRUD для текстовых страниц
 * @package tests\codeception\app\unit\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PageCrudTest extends CrudTestCase
{

    public $indexRoute = "/main/admin/pages/index";

    public $createRoute = "/main/admin/pages/create";

    public $updateRoute = "/main/admin/pages/update";

    public $deleteRoute = "/main/admin/pages/delete";

    public $groupDeleteRoute = "/main/admin/pages/groupdelete";

    public $viewRoute = "/main/admin/pages/view";

    public $upRoute = "/main/admin/pages/up";

    public $downRoute = "/main/admin/pages/down";

    public $replaceRoute = "/main/admin/pages/replace";

    /**
     * Тест списка моделей
     */
    public function testAdminPage()
    {

        $route = $this->indexRoute;

        $this->getRequest($route);

        $res = Yii::$app->runAction($route);

        $this->specify('action result is text', function () use ($res) {

            $this->assertTrue(strlen($res)>0);

        });

    }


    /**
     * Тест создания текстовой страницы
     */
    public function testCreatePage()
    {

        $route = $this->createRoute;

        $this->postRequest([$route, "parent_id"=>TActiveRecord::ROOT_ID]);

        $_POST = [

            'Pages'=>[
                'title'=>'Test create',
                'code'=>'test-create',
            ]
        ];

        $res = Yii::$app->runAction($route, ["parent_id"=>TActiveRecord::ROOT_ID]);

        $model = Pages::findOne(["code"=>"test-create"]);

        $this->specify('page must be created', function () use ($model, $res) {

            expect("model exists in database",!empty($model))->true();
            expect("action return object", is_object($res))->true();

        });

    }

    /**
     * Тест изменения текстовой страницы
     */
    public function testUpdatePage()
    {

        $model = Pages::findOne(["code"=>Pages::INDEX_CODE]);

        $route = $this->updateRoute;

        $this->postRequest([$route, "id"=>$model->id]);

        $newTitle = 'Main-updated';

        $_POST = [

            'Pages'=>[
                'title'=>$newTitle,
                'code'=>Pages::INDEX_CODE,
            ]
        ];

        Yii::$app->runAction($route, ["id"=>$model->id]);

        $model->refresh();

        $this->specify('page must be updated', function () use ($model, $newTitle) {

            $this->assertTrue($model->title==$newTitle);

        });

    }

    /**
     * Тест удаления текстовой страницы
     */
    public function testDeletePage()
    {

        $model = Pages::findOne(["code"=>"test"]);

        $route = $this->deleteRoute;

        $this->postRequest([$route, "id"=>$model->id]);

        Yii::$app->runAction($route, ["id"=>$model->id]);

        $model = Pages::findOne(["code"=>"test"]);

        $this->specify('page does not exists', function () use ($model) {

            $this->assertTrue($model===null);

        });

    }

    /**
     * Тест группового удаления текстовых страниц
     */
    public function testGroupDeletePage()
    {

        $models = Pages::findOne(TActiveRecord::ROOT_ID)->children()->all();

        $route = $this->groupDeleteRoute;

        $this->postRequest($route);

        $_POST = [
            "selection"=>array_keys(ArrayHelper::map($models, "id", "id")),
        ];

        Yii::$app->runAction($route);

        $count =  Pages::findOne(TActiveRecord::ROOT_ID)->children()->orderBy(null)->count();

        $this->specify('root model has no children', function () use ($count) {

            $this->assertTrue($count==0);

        });

    }

    /**
     * Тест просмотра текстовой страницы
     */
    public function testViewPage()
    {

        $model = Pages::findOne(["code" => "main"]);

        $route = $this->viewRoute;

        $this->getRequest([$route, "id"=>$model->id]);

        $res = Yii::$app->runAction($route, ["id" => $model->id]);

        $this->specify('action result is text', function () use ($res) {

            $this->assertTrue(strlen($res)>0);

        });

    }

    /**
     * Тест перемещения вверх текстовой страницы
     */
    public function testUpPage()
    {

        $model = Pages::findOne(["code" => "test"]);

        $route = $this->upRoute;

        $this->getRequest([$route, "id"=>$model->id]);

        Yii::$app->runAction($route, ["id" => $model->id]);

        $model->refresh();

        $prev = $model->prev()->one();

        $this->specify('previous model does not exists', function () use ($prev) {

            $this->assertTrue($prev === null);

        });

    }

    /**
     * Тест перемещения вниз текстовой страницы
     */
    public function testDownPage()
    {

        $model = Pages::findOne(["code" => "main"]);

        $route = $this->downRoute;

        $this->getRequest([$route, "id"=>$model->id]);

        Yii::$app->runAction($route, ["id" => $model->id]);

        $model->refresh();

        $next = $model->next()->one();

        $this->specify('next model does not exists', function () use ($next) {

            $this->assertTrue($next === null);

        });

    }

    /**
     * Тест перемещения текстовой страницы
     */
    public function testReplacePage()
    {

        $model = Pages::findOne(["code"=>"test"]);

        $parentModel = Pages::findOne(["code"=>"main"]);

        $route = $this->replaceRoute;

        $this->postRequest($route);

        $_POST = [

            "selection" => [$model->id],
            "replace_parent_id" => $parentModel->id,
        ];

        Yii::$app->runAction($route);

        $model->refresh();

        $newParent = $model->parents(1)->one();

        $this->specify('parent of model has changed', function () use ($parentModel, $newParent) {

            $this->assertTrue($parentModel->id==$newParent->id);

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
            'pages' => [
                'class' => PagesFixture::className(),
                'dataFile' => '@tests/codeception/common/fixtures/data/pages.php'
            ],
        ];
    }

}
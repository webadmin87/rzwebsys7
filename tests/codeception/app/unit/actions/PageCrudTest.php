<?php
namespace tests\codeception\app\unit\actions;

use app\modules\main\models\Pages;
use common\db\TActiveRecord;
use tests\codeception\common\fixtures\UserFixture;
use Yii;
use app\modules\main\models\User;
use Codeception\Specify;
use tests\codeception\app\unit\DbTestCase;
use app\modules\main\modules\admin;
use yii\helpers\Url;

/**
 * Class PageCrudTest
 * Тест CRUD для текстовых страниц
 * @package tests\codeception\app\unit\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PageCrudTest extends DbTestCase
{

    use Specify;

    public function setUp()
    {
        parent::setUp();

        Yii::$app->user->login(User::findByUsername('root'));

    }

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    /**
     * Тест создания текстовой страницы
     */
    public function testCreatePage()
    {

        $route = "/main/admin/pages/create";

        $_SERVER["REQUEST_URI"] = Url::toRoute([$route, "parent_id"=>TActiveRecord::ROOT_ID]);

        $page = [

            'Pages'=>[
                'title'=>'Test page',
                'code'=>'test',
            ]
        ];

        Yii::$app->request->setRawBody(http_build_query($page));

        $res = Yii::$app->runAction($route, ["parent_id"=>TActiveRecord::ROOT_ID]);

        $model = Pages::findOne(["code"=>"test"]);

        $this->specify('page must be created', function () use ($model, $res) {

            expect("model exists in databese",!empty($model))->true();
            expect("action return object", is_object($res))->true();

        });

    }

    /**
     * Тест изменения текстовой страницы
     */
    public function testUpdatePage()
    {

        $model = Pages::findOne(["code"=>Pages::INDEX_CODE]);

        $route = "/main/admin/pages/update";

        $_SERVER["REQUEST_URI"] = Url::toRoute([$route, "id"=>$model->id]);

        $page = [

            'Pages'=>[
                'title'=>'Main-updated',
                'code'=>Pages::INDEX_CODE,
            ]
        ];

        Yii::$app->request->setRawBody(http_build_query($page));

        Yii::$app->runAction($route, ["id"=>$model->id]);

        $model->refresh();

        $this->specify('page must be updated', function () use ($model) {

            expect("model title changed", $model->title=='Main-updated' )->true();

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
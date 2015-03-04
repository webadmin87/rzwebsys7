<?php

namespace tests\codeception\app\unit;

use Yii;
use app\modules\main\models\User;
use Codeception\Specify;
use yii\helpers\Url;

/**
 * Class CrudTestCase
 * Базовы тест для CRUD
 * @package tests\codeception\app\unit
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CrudTestCase extends DbTestCase
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
     * Эмулирует GET запрос
     * @param mixed $route
     */
    protected function  getRequest($route)
    {
        $_SERVER["REQUEST_URI"] = Url::toRoute($route);

    }

    /**
     * Эмулирует POST запрос
     * @param mixed $route
     */
    protected function postRequest($route)
    {
        $_SERVER["REQUEST_URI"] = Url::toRoute($route);

        $_SERVER['REQUEST_METHOD'] = "POST";
    }

}

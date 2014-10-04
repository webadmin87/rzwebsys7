<?php

namespace tests\codeception\app\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \tests\codeception\app\AcceptanceTester|\tests\codeception\app\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = 'site/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $this->actor->fillField('input[name="LoginForm[username]"]', $username);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('login-button');
    }
}

<?php
namespace app\modules\main\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * Модель формы логина
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class LoginForm extends Model
{
    /**
     * @var string имя пользователя
     */
    public $username;

    /**
     * @var string пароль
     */
    public $password;

    /**
     * @var bool запомнить меня
     */
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            "username" => Yii::t('main/app', 'Username'),
            "password" => Yii::t('main/app', 'Password'),
            "rememberMe" => Yii::t('main/app', 'Remember me'),
        ];
    }

}

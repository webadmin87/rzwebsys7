<?php
namespace app\modules\main\models;

use common\db\ActiveRecord;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * Модель пользователей
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $role
 * @property boolean $active
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    use \app\modules\main\components\PermissionTrait;

    const ROLE_ROOT = "root";

    const ROLE_ADMIN = "admin";

    CONST ROLE_USER = "user";

    /**
     * @var string пароль
     */

    public $password;

    /**
     * @var string подтверждение пароля
     */

    public $confirm_password;

    /**
     * Возвращает имя таблицы
     * @return string
     */

    public static function tableName()
    {
        return "user";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'active' => true]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'active' => true,
        ]);
    }

    /**
     * Возвращает массив ролей пользователей
     * @return array
     */

    public static function getRolesNames()
    {

        $roles = Yii::$app->authManager->getRoles();

        $arr = array();

        foreach ($roles AS $role)
            $arr[$role->name] = $role->name;

        return $arr;

    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (!empty($this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
    }

    /**
     * @inheritdoc
     */

    public function afterSave($insert, $changeAttributes)
    {

        parent::afterSave($insert, $changeAttributes);

        $auth = Yii::$app->authManager;

        $auth->revokeAll($this->getId());

        $role = $auth->getRole($this->role);

        $auth->assign($role, $this->getId());

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $parentRule = parent::rules();

        $rule = [

            ['username', 'unique'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'unique'],
            ['confirm_password', 'compare', 'skipOnEmpty' => false, 'compareAttribute' => 'password'],
            [['password', 'confirm_password'], 'required', 'on' => ['insert']],
        ];

        return array_merge($parentRule, $rule);

    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\UserMeta::className();
    }

}

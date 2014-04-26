<?php
namespace app\modules\main\models;

use Yii;
use yii\base\NotSupportedException;
use common\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * User model
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

    public $password;

    public $confirm_password;

    public static function tableName() {
        return "user";
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(!empty($this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }


            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert) {

        parent::afterSave($insert);

        $auth = Yii::$app->authManager;

        $auth->revokeAll($this->getId());

        $role = $auth->getRole($this->role);

        $auth->assign($role, $this->getId());

    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
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
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'active' => true]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
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
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Security::validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
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
        return [
            ['active', 'default', 'value' => true, 'on'=>['insert', 'update']],

            ['username', 'filter', 'filter' => 'trim', 'on'=>['insert', 'update']],
            ['username', 'required', 'on'=>['insert', 'update']],
            ['username', 'unique', 'on'=>['insert', 'update']],
            ['username', 'string', 'min' => 2, 'max' => 255, 'on'=>['insert', 'update']],

            ['role', 'required', 'on'=>['insert', 'update']],

            ['email', 'filter', 'filter' => 'trim', 'on'=>['insert', 'update']],
            ['email', 'required', 'on'=>['insert', 'update']],
            ['email', 'email', 'on'=>['insert', 'update']],
            ['email', 'unique', 'on'=>['insert', 'update']],
            ['password', 'string', 'min' => 6, 'on'=>['insert', 'update']],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'on'=>['insert', 'update']],
            ['password', 'required', 'on'=>['insert']],
        ];
    }



    public function getRolesNames() {

        $roles = Yii::$app->authManager->getRoles();

        $arr = array();

        foreach($roles AS $role)
            $arr[$role->name] = $role->name;

        return $arr;

    }

}

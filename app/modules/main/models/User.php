<?php
namespace app\modules\main\models;

use app\modules\import\models\ICsvImportable;
use common\db\ActiveRecord;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

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
class User extends ActiveRecord implements IdentityInterface, ICsvImportable
{

    use \app\modules\main\components\PermissionTrait;

    const ROLE_ROOT = "root";

    const ROLE_ADMIN = "admin";

    const ROLE_USER = "user";

    const SCENARIO_REGISTER = "register";

    const VERIFY_CODE = "d58e3582afa99040e27b92b13c8f2280";

    /**
     * @var string значение капчи
     */
    public $verifyCode;

    /**
     * @var string пароль
     */
    public $password;

    /**
     * @var string подтверждение пароля
     */
    public $confirm_password;

    /**
     * @var array массив сценариев при которых инициалихируются начальные значения
     */
    protected $initScenarios = [self::SCENARIO_INSERT, self::SCENARIO_REGISTER];

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
     * Возвращает массив ролей, которые может создавать пользователь
     * @return array
     */
    public function getPermittedRoles()
    {

        $roles =  Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        $all = [];

        foreach($roles AS $role) {
            $all[] = $role;
            $all = array_merge($all, $this->getRoleDescendant($role));
        }

        return $all;

    }

    /**
     * Возвращает все роли - потомки переданной роли
     * @param \yii\rbac\Role $role роль
     * @return array
     */
    public function getRoleDescendant(\yii\rbac\Role $role)
    {

        $arr = [];

        $children = Yii::$app->authManager->getChildren($role->name);

        foreach($children AS $child) {

            if($child instanceof \yii\rbac\Role) {

                $arr[] = $child;

                $arr = array_merge($arr, $this->getRoleDescendant($child));

            }

        }

        return $arr;

    }

    /**
     * Возвращает массив ролей пользователей
     * @return array
     */
    public static function getRolesNames()
    {

        if(Yii::$app->user->isGuest)
            return [];

        $roles = Yii::$app->user->identity->getPermittedRoles();

        $arr = ArrayHelper::map($roles, "name", "name");

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
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
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

            ['username', 'unique', 'except'=>ActiveRecord::SCENARIO_SEARCH],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'unique'],
            ['confirm_password', 'compare', 'skipOnEmpty' => false, 'compareAttribute' => 'password'],
            [['password', 'confirm_password'], 'required', 'on' => ['insert', 'register']],
            ['verifyCode', 'compare', 'skipOnEmpty' => false, 'compareValue' => self::VERIFY_CODE, 'on' => [self::SCENARIO_REGISTER]]
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

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		$arr =  parent::fields();

		$disabled = ["auth_key", "password_hash", "password_reset_token"];

		return array_diff($arr, $disabled);

	}

    /**
     * Возвращает массив атрибутов доступных для импорта из csv
     * @return array
     */
    public function getCsvAttributes()
    {
        $attrs = array_keys($this->getAttributes(null, ['auth_key', 'password_hash', 'password_reset_token']));

        $attrs[] = "password";

        $attrs[] = "confirm_password";

        return $attrs;

    }

    /**
     * @inheritdoc
     */
    public static function getEntityName()
    {
        return Yii::t('main/app', 'Users');
    }


}

<?php
namespace common\db\fields;

use yii\helpers\ArrayHelper;
use Yii\widgets\ActiveForm;

/**
 * Class PasswordField
 * Поле ввода пароля модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PasswordField extends TextField
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\PasswordInput";

    /**
     * Длина пароля
     */

    public $passwordLength = 6;

    /**
     * Правила валидации
     * @return array
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'string', 'min' => $this->passwordLength];

        return $rules;

    }

}
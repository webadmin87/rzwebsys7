<?php
namespace common\db\fields;

/**
 * Class PasswordField
 * Поле ввода пароля модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PasswordField extends TextField {

    /**
     * Длина пароля
     */

    const PASSWORD_LENGTH = 6;

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function form(ActiveForm $form, Array $options = []) {

        return $form->field($this->$model, $this->attr)->passwordInput($options);

    }

    /**
     * Правила валидации
     * @return array
     */

    public function rules() {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'string', 'min' => self::PASSWORD_LENGTH];

        return $rules;

    }


}
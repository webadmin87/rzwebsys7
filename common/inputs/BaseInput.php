<?php
namespace common\inputs;

use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\widgets\ActiveForm;
use \common\db\fields\Field;

/**
 * Class BaseInput
 * Базовый класс полей ввода форм
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
abstract class BaseInput extends Object
{

    /**
     * @var Field поле модели
     */
    public $modelField;

    /**
     * @var array html атрибуты
     */
    public $options = [];

    /**
     * @var array парамеиры виджета
     */
    public  $widgetOptions = [];

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @param bool|int $index инднкс модели при табличном вводе
     * @return string
     */
    abstract public function renderInput(ActiveForm $form, Array $options = [], $index = false);

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if(empty($this->modelField) OR ! $this->modelField instanceof Field)
            throw new InvalidConfigException("Property 'modelField' must be instance of ".Field::className());



    }

    /**
     * Возвращает имя атрибута для поля формы
     * @param bool|int $index индекс модели при табличном вводе
     * @param string $attr атрибут
     * @return string
     */
    protected function getFormAttrName($index, $attr)
    {

        return ($index !== false) ? "[$index]$attr" : $attr;

    }

} 
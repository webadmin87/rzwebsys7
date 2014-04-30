<?php
namespace common\db;

use Yii;
use yii\db\ActiveRecord AS YiiRecord;

/**
 * Class ActiveRecord
 * Надстройка над ActiveRecord фпеймворка.
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */

abstract class ActiveRecord extends YiiRecord {

    /**
     * Сценарии валидации
     */

    const SCENARIO_INSERT = "insert";

    const SCENARIO_UPDATE = "update";

    const SCENARIO_SEARCH = "search";

    /**
     * Базовые сценарии
     * @var array
     */
    protected $_baseScenarios = [self::SCENARIO_INSERT, self::SCENARIO_UPDATE, self::SCENARIO_SEARCH];

    /**
     * @var \common\db\MetaFields объект с описанием полей модели
     */
    protected $metaFields;

    /**
     * Сченари валидации
     * @return array
     *
     */
    public function  scenarios() {

        $scenarios = parent::scenarios();

        foreach($this->_baseScenarios AS $scenario) {

            if(!isset($scenarios[$scenario])) {

                $scenarios[$scenario] = $scenarios[YiiRecord::SCENARIO_DEFAULT];
            }

        }

        return $scenarios;

    }

    /**
     * Возвращает объект с описанием полей модели
     * @return MetaFields
     */

    public function getMetaFields() {

        if($this->metaFields === null) {

            $class = $this->metaClass();

            $this->metaFields =  Yii::createObject($class, [$this]);

        }

        return $this->metaFields;

    }

    /**
     * Правила валидации Формируем из полей
     * @return array
     */

    public function rules() {

        $fields = $this->getMetaFields()->getFields();

        $rules = [];

        foreach($fields AS $field) {

            $rules = array_merge($rules, $field->rules());

        }

        return $rules;

    }

    /**
     * Подписи атрибутов
     * @return array
     */

    public function attributeLabels() {

        $fields = $this->getMetaFields()->getFields();

        $labels = [];

        foreach($fields AS $field) {

            $labels[$field->attr] = $field->title;

        }

        return $labels;

    }

    /**
     * Поведения
     * @return array
     */

    public function behaviors() {

        $fields = $this->getMetaFields()->getFields();

        $behaviors = [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];

        foreach($fields AS $field) {

            $behaviors = array_merge($behaviors, $field->behaviors());

        }

        return $behaviors;

    }

    /**
     * Возвращает имя класса содержащего описание полей модели
     * @return string
     */

    public abstract function metaClass();

}
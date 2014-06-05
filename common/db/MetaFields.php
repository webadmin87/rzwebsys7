<?php

namespace common\db;

use Yii;
use yii\base\Object;
use common\db\fields;
use yii\helpers\ArrayHelper;

/**
 * Class MetaFields
 * Класс содержащий описание полей модели
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */

abstract class MetaFields extends Object
{

    /**
     * Вкладка формы по умолчанию
     */

    const DEFAULT_TAB = "default";

    /**
     * @var ActiveRecord модель - владелец
     */

    protected $owner;

    /**
     * @var array массив объектов полей модели
     */

    protected $fields;

    /**
     * Конструктор
     * @param ActiveRecord $owner
     */

    public function __construct(ActiveRecord $owner, $params=array())
    {

        $this->owner = $owner;

        parent::__construct($params);

    }

    /**
     * Возвращает массив объектов полей модели
     * @return array
     */

    public function getFields()
    {

        if ($this->fields === null) {

            $this->fields = [];

            $config = ArrayHelper::merge($this->defaultConfig(), $this->config());

            foreach ($config AS $config) {

                if(!is_array($config))
                    continue;

                $this->fields[] = Yii::createObject($config["definition"], $config["params"]);

            }


        }

        return $this->fields;

    }

    /**
     * Возвращает поля по коду вкладки
     * @param string $tab код вкладки
     * @return array
     */

    public function getFieldsByTab($tab)
    {

        $fields = $this->getFields();

        $arr = [];

        foreach ($fields AS $field) {

            if ($field->tab == $tab AND $field->showInForm)
                $arr[] = $field;

        }

        return $arr;
    }

    /**
     * Массив вкладок формы редактирования модели (key=>name)
     * @return array
     */

    public function tabs()
    {
        return [self::DEFAULT_TAB => Yii::t('core', 'Element')];
    }

    /**
     * Конфигурация полей по умолчанию
     * @return array
     */

    protected function defaultConfig()
    {

        $authorsData = function() {

            $authorQuery = Yii::createObject(\yii\db\Query::className());
            $authorCommand = $authorQuery->select('id, username')->from('user')->createCommand();
            $authors = $authorCommand->queryAll();
            return ArrayHelper::map($authors, 'id', 'username');

        };



        return [

            "id" => [
                'definition' => [
                    "class" => fields\PkField::className(),
                    "title" => "ID",
                ],
                "params" => [$this->owner, "id"]
            ],

            "created_at" => [
                'definition' => [
                    "class" => fields\TimestampField::className(),
                    "title" => Yii::t('core', 'Created'),
                ],
                "params" => [$this->owner, "created_at"]
            ],


            "updated_at" => [
                'definition' => [
                    "class" => fields\TimestampField::className(),
                    "title" => Yii::t('core', 'Updated'),
                ],
                "params" => [$this->owner, "updated_at"]
            ],

            "active" => [
                "definition" => [
                    "class" => fields\CheckBoxField::className(),
                    "title" => Yii::t('core', 'Active'),
                ],
                "params" => [$this->owner, "active"]
            ],

            "author_id" => [
                'definition' => [
                    "class" => fields\HasOneField::className(),
                    "title" => Yii::t('core', 'Author'),
                    "showInForm" => true,
                    "data" => $authorsData,
                    "gridAttr"=>"username",
                ],
                "params" => [$this->owner, "author_id", "author"]
            ],

        ];

    }

    /**
     * Данный метод должен возвращать массив конфигураций объектов для создания полей модели
     * через Yii::createObject()
     *
     * Пример конфигурации:
     *
     * return [
     *
     *      "title"=>[
     *                  "definition"=>[
     *                      "class"=>\common\db\fields\TextField::className(),
     *                      "title"=>"Название",
     *                  ],
     *                  "params"=>[$this->owner, "title"]
     *              ],
     * ];
     *
     * @return array
     */

    abstract protected function config();


}
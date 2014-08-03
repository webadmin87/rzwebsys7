<?php
namespace common\db;

use app\modules\main\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord as YiiRecord;

/**
 * Class ActiveRecord
 * Надстройка над ActiveRecord фпеймворка.
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
abstract class ActiveRecord extends YiiRecord
{

    /**
     * Сценарии валидации
     */

    const SCENARIO_INSERT = "insert";

    const SCENARIO_UPDATE = "update";

    const SCENARIO_SEARCH = "search";

    /**
     * Значение сортировки по умолчанию
     */

    const DEFAULT_SORT = 500;

    /**
     * @var array значение сортировки по умолчанию
     */

    protected $_defaultSearchOrder = ["id" => SORT_DESC];

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
     * @inheritdoc
     * Устанавливаем активность по умолчанию при создании новой модели
     */

    public function init()
    {

        if ($this->scenario == self::SCENARIO_INSERT) {

            $this->active = true;

        }

    }

    /**
     * Сченари валидации
     * @return array
     *
     */
    public function  scenarios()
    {

        $scenarios = parent::scenarios();

        foreach ($this->_baseScenarios AS $scenario) {

            if (!isset($scenarios[$scenario])) {

                $scenarios[$scenario] = $scenarios[YiiRecord::SCENARIO_DEFAULT];
            }

        }

        return $scenarios;

    }

    /**
     * Правила валидации Формируем из полей
     * @return array
     */

    public function rules()
    {

        $fields = $this->getMetaFields()->getFields();

        $rules = [];

        foreach ($fields AS $field) {

            if ($field->rules())
                $rules = array_merge($rules, $field->rules());

        }

        return $rules;

    }

    /**
     * Возвращает объект с описанием полей модели
     * @return MetaFields
     */

    public function getMetaFields()
    {

        if ($this->metaFields === null) {

            $class = $this->metaClass();

            $this->metaFields = Yii::createObject($class, [$this]);

        }

        return $this->metaFields;

    }

    /**
     * Возвращает имя класса содержащего описание полей модели
     * @return string
     */

    public abstract function metaClass();

    /**
     * Подписи атрибутов
     * @return array
     */

    public function attributeLabels()
    {

        $fields = $this->getMetaFields()->getFields();

        $labels = [];

        foreach ($fields AS $field) {

            $labels[$field->attr] = $field->title;

        }

        return $labels;

    }

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {

        $fields = $this->getMetaFields()->getFields();

        $behaviors = [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return date("Y-m-d H:i:s");
                },
            ],
            'tagCache' => [
                'class' => \common\behaviors\TagCache::className(),
            ],
        ];

        foreach ($fields AS $field) {

            if ($field->behaviors())
                $behaviors = array_merge($behaviors, $field->behaviors());

        }

        return $behaviors;

    }

    /**
     * Возвращает провайдер данных для поиска
     * @param array $params массив значений атрибутов модели
     * @param array $dataProviderConfig параметры провайдера данных
     * @param \common\db\ActiveQuery $query запрос
     * @return \yii\data\ActiveDataProvider
     */

    public function search($params, $dataProviderConfig = [], $query = null)
    {

        $fields = $this->getMetaFields()->getFields();

        $query = $query ? $query : static::find();

        $config = array_merge([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ], $dataProviderConfig);

        $dataProvider = Yii::createObject($config);

        $dataProvider->getSort()->defaultOrder = $this->_defaultSearchOrder;

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        foreach ($fields AS $field)
            $field->search($query);

        return $dataProvider;

    }

    /**
     * @inheritdoc
     * @return \common\db\ActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(\common\db\ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (empty($this->author_id)) {

                $id = Yii::$app->user->id;

                $this->author_id = $id ? $id : 0;

            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return User возвращает автора модели
     */

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Возвращает модель правил доступа
     * @return \common\rbac\IPermission|null
     */

    public function getPermission()
    {

        return null;

    }

}
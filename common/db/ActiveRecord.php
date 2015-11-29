<?php
namespace common\db;

use app\modules\main\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord as YiiRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveRecord
 * Надстройка над ActiveRecord фпеймворка.
 * @property integer $id идентификатор
 * @property boolean $active признак активности
 * @property datetime $created_at время создания
 * @property datetime $updated_at время редактирования
 * @property integer $author_id идентификатор автора
 * @property User $author автор
 * @property-read MetaFields $metaFields объект с описанием полей модели
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
abstract class ActiveRecord extends YiiRecord
{

    use CreatedAtSearchTrait;

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
     * @var string alias директории с шаблонами для форм
     */
    public $tplDir;

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
    protected $_metaFields;

    /**
     * @var array массив сценариев при которых инициалихируются начальные значения
     */
    protected $initScenarios = [self::SCENARIO_INSERT];

    /**
     * Возвращает имя сущности
     * @return string
     */
    public static function getEntityName()
    {

        return end(explode("\\", get_called_class()));

    }


    /**
     * @inheritdoc
     * Устанавливаем активность по умолчанию при создании новой модели
     */

    public function init()
    {

        if (in_array($this->scenario, $this->initScenarios)) {

            $this->initValues();

        }

    }

    /**
     * Инициализация начальных значений
     */
    public function initValues()
    {

        $fields = $this->getMetaFields()->getFields();

        foreach ($fields AS $field) {

            $attr = $field->attr;

            if($field->initValue !== null)
                $this->$attr = $field->initValue;

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

        $rules = [
            [["createdAtFrom", "createdAtTo"], "safe"],
        ];

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

        if ($this->_metaFields === null) {

            $class = $this->metaClass();

            $this->_metaFields = Yii::createObject($class, [$this]);

        }

        return $this->_metaFields;

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

        $labels = [

            "createdAtFrom"=>Yii::t('core', 'Created from'),
            "createdAtTo"=>Yii::t('core', 'Created to'),

        ];

        foreach ($fields AS $field) {

          $labels = ArrayHelper::merge($labels, $field->getAttributeLabel());

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
                'value' => Yii::createObject(["class"=>Expression::className()],['NOW()']),
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

        $this->load($params);

        $this->validate();

        foreach ($fields AS $field) {

            if($field->search)
                $field->applySearch($query);

        }

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

	/**
	 * Изменилась ли активность модели
	 * @return bool
	 */
	public function hasChangeActive() {

		$oldArr = $this->oldAttributes;

		$new = (int) $this->active;

		$old = (int) $oldArr["active"];

		if($new != $old)
			return true;

		return false;
	}

    /**
     * Возвращает название элемента сущности
     * @return string
     */
    public function getItemLabel()
    {

        $res = [];

        if($this->hasAttribute("id") AND $this->id)
            $res[]=$this->id;

        if($this->hasAttribute("title") AND $this->title)
            $res[]=$this->title;

        return implode(" - ", $res);

    }

}

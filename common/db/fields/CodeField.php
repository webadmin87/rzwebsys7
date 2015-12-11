<?php
namespace common\db\fields;

use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\UniqueValidator;

/**
 * Class CodeField
 * Поле символьного кода
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CodeField extends TextField
{

    /**
     * Преффикс поведения
     */
    const BEHAVIOR_PREF = "code";

    /**
     * @var array параметры валидатора уникальности
     */

    public $uniqueParams = [];

    /**
     * @var string атрибут из которого генерировать символьный код
     */

    public $generateFrom;

    /**
     * @var array настройки поведения генерации символьного кода
     */

    public $slugOptions = [];

    /**
     * @var string имя валидатора для проверки уникальности
     */
    public $uniqueValidatorClassName;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        parent::init();
        if($this->uniqueValidatorClassName === null) {
            $this->uniqueValidatorClassName = UniqueValidator::className();
        }
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $parent = parent::behaviors();

        if(!empty($this->generateFrom) AND $this->model->scenario != ActiveRecord::SCENARIO_SEARCH) {

            $code = self::BEHAVIOR_PREF . ucfirst($this->attr);

            $parent[$code] = ArrayHelper::merge([
                'class' => \Zelenin\yii\behaviors\Slug::className(),
                'slugAttribute' => $this->attr,
                'attribute' => $this->generateFrom,
                'ensureUnique' => true,
                'translit' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => true,
                'uniqueValidator' => array_merge(['class'=>$this->uniqueValidatorClassName], $this->uniqueParams),
                'transliterateOptions' => 'Russian-Latin/BGN;'
            ], $this->slugOptions);

        }

        return $parent;
    }


    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        if(empty($this->generateFrom) && $this->uniqueValidatorClassName) {

            $rules[] = array_merge([$this->attr, $this->uniqueValidatorClassName, 'except' => ActiveRecord::SCENARIO_SEARCH], $this->uniqueParams);

        }

        $rules[] = [$this->attr, 'match', 'pattern' => '/^[A-z0-9_-]+$/i'];

        return $rules;

    }

}
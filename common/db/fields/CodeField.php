<?php
namespace common\db\fields;

use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
                'uniqueValidator' => $this->uniqueParams,
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

        if(empty($this->generateFrom))
            $rules[] = array_merge([$this->attr, 'unique', 'except' => ActiveRecord::SCENARIO_SEARCH], $this->uniqueParams);

        $rules[] = [$this->attr, 'match', 'pattern' => '/^[A-z0-9_-]+$/i'];

        return $rules;

    }

}
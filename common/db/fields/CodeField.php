<?php
namespace common\db\fields;
use common\db\ActiveRecord;
/**
 * Class CodeField
 * Поле символьного кода
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CodeField extends TextField {

    /**
     * @var array параметры валтдатора уникальности
     */

    public $uniqueParams = [];

    /**
     * @inheritdoc
     */

    public function rules() {

        $rules = parent::rules();

        $rules[] = array_merge([$this->attr, 'unique', 'except'=>ActiveRecord::SCENARIO_SEARCH], $this->uniqueParams);

        $rules[] = [$this->attr, 'match', 'pattern'=>'/^[A-z0-9_-]+$/i'];

        return $rules;

    }


}
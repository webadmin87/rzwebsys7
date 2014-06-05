<?php
namespace common\db\fields;

/**
 * Class PkField
 * Поле первичного ключа
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PkField extends  Field {

    /**
     * @inheritdoc
     */

    public $showInForm = false;

    /**
     * @inheritdoc
     */

    public function rules() {

        $rules = [[$this->attr, 'safe', 'on' => \common\db\ActiveRecord::SCENARIO_SEARCH]];

        return $rules;

    }

}
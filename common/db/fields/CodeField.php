<?php
namespace common\db\fields;

/**
 * Class CodeField
 * Поле символьного кода
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CodeField extends TextField {

    /**
     * @inheritdoc
     */

    public function rules() {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'unique'];

        $rules[] = [$this->attr, 'regexp', 'pattern'=>'/^[A-z0-9_-]$/i'];

        return $rules;

    }


}
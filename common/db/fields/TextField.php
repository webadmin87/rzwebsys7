<?php
namespace common\db\fields;
use common\db\ActiveQuery;

/**
 * Class TextField
 * Текстовое поле модели.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TextField extends Field
{

    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'filter', 'filter' => 'trim'];

        return $rules;

    }

    /**
     * @inheritdoc
     */
    protected function search(ActiveQuery $query)
    {

        $table = $this->model->tableName();

        $attr = $this->attr;

        $query->andFilterWhere(["~*", "{{%$table}}.{{%$attr}}", preg_quote($this->model->{$this->attr})]);

    }

}
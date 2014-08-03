<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class TableInput
 * Виджет табличного ввода
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TableInput extends Widget
{

    /**
     * @var \yii\widgets\ActiveForm форма
     */

    public $form;

    /**
     * @var \common\db\ActiveRecord[] массив моделей
     */
    public $models = [];

    /**
     * @var array html атрибуты таблицы
     */

    public $tableOptions = [];

    /**
     * @inheritdoc
     */
    public function run()
    {

        $html = Html::beginTag('table', $this->tableOptions);

        foreach ($this->models AS $i => $model) {

            $html .= $this->renderLine($model, $i);

        }

        $html .= Html::endTag('table');

        return $html;
    }

    /**
     * Возвращает строку формы
     * @param \common\db\ActiveRecord $model модель
     * @param int $index номер строки
     * @return string
     */

    protected function renderLine($model, $index)
    {

        $html = Html::beginTag('tr');

        $meta = $model->getMetaFields();

        $fields = $meta->getFields();

        foreach ($fields AS $field) {

            if (!$field->showInTableInput)
                continue;

            $html .= Html::beginTag('td');

            $html .= $field->form($this->form, [], $index);

            $html .= Html::endTag('td');

        }

        $html .= Html::endTag('tr');

        return $html;
    }

}
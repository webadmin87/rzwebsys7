<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;

/**
 * Class ExtFilter
 * Форма расширенного фильтра модели для админки. Формируется на основе \common\db\MetaFields модели
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ExtFilter extends Widget
{

    /**
     * Преффикс идентификатора виджета
     */

    const FORM_ID_PREF = "ext-form-";

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var array параметры \yii\widgets\ActiveForm
     */

    public $formOptions = [];

    /**
     * @var int количество колонок в фильтре. 12 должно быть кратно установленному значению.
     */

    public $cols = 3;

    /**
     * @var string шаблон
     */

    public $tpl = "ext-form";

    /**
     * @var array массив полей модели
     */

    protected $fields = array();

    /**
     * @var array параметры \yii\widgets\ActiveForm по умолчанию
     */

    protected $defaultFormOptions = [
        'action' => ['index'],
        'method' => 'get',
    ];

    /**
     * @var string идентификатор виджета
     */

    protected $id;

    /**
     * @inheritdoc
     */

    public function init()
    {

        $model = $this->model;

        $this->id = strtolower(self::FORM_ID_PREF . str_replace("\\", "-", $model::className()));

        $this->loadFields();

    }

    /**
     * Формирует массив полей выводимых в фильтре
     */

    protected function loadFields()
    {

        $fields = $this->model->getMetaFields()->getFields();

        foreach ($fields AS $field) {

            if ($field->showInExtendedFilter)
                $this->fields[] = $field;

        }

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        $formOptions = array_merge($this->defaultFormOptions, $this->formOptions);

        return $this->render($this->tpl, [
                "model" => $this->model,
                "formOptions" => $formOptions,
                "id" => $this->id,
                "cols" => $this->cols,
                "fields" => $this->fields,
            ]
        );

    }

}
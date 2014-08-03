<?php
namespace common\db\fields;

use common\db\ActiveQuery;
use common\db\ActiveRecord;
use Yii;
use Yii\base\Object;
use Yii\widgets\ActiveForm;

/**
 * Class TextField
 * Базовый класс полей.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Field extends Object
{

    /**
     * @var \common\db\ActiveRecord модель
     */
    public $model;

    /**
     * @var string атрибут модели
     */
    public $attr;

    /**
     * @var string подпись атрибута
     */

    public $title;

    /**
     * @var string вкладка формы на которой должно быть расположено поле
     */

    public $tab = \common\db\MetaFields::DEFAULT_TAB;

    /**
     * @var bool отображать в гриде
     */
    public $showInGrid = true;

    /**
     * @var bool отображать при детальном просмотре
     */
    public $showInView = true;

    /**
     * @var bool отображать в форме
     */
    public $showInForm = true;

    /**
     * @var bool отображать в фильтре грида
     */
    public $showInFilter = true;

    /**
     * @var bool отображать в расширенном фильре
     */
    public $showInExtendedFilter = true;

    /**
     * @var bool отображать поле при табличном вводе
     */

    public $showInTableInput = true;

    /**
     * @var bool использоваь ли валидатор safe
     */

    public $isSafe = true;

    /**
     * @var bool обязательно ли поле к заполнению
     */

    public $isRequired = false;

    /**
     * @var bool участвует ли поле при поиске
     */

    public $search = true;

    /**
     * @var bool возможность редактирования значения поля в гриде
     */

    public $editInGrid = false;

    /**
     * @var string действие для редактирования модели из грида
     */

    public $editableAction = "editable";

    /**
     * @var mixed значение фильтра грида установленное
     */
    protected $gridFilter;

    /**
     * Конструктор
     * @param ActiveRecord $model модель
     * @param string $attr атрибут
     * @param array $config массив значений атрибутов
     */

    public function __construct(ActiveRecord $model, $attr, $config = [])
    {

        $this->model = $model;

        $this->attr = $attr;

        parent::__construct($config);

    }

    public function tableForm(ActiveForm $form, $index, Array $options = [])
    {

    }

    /**
     * Формирование Html кода поля для вывода в расширенном фильтре
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function extendedFilterForm(ActiveForm $form, Array $options = [])
    {

        return $this->form($form, $options);

    }

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @param bool|int $index инднкс модели при табличном вводе
     * @return string
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

        return $form->field($this->model, $this->getFormAttrName($index))->textInput($options);

    }

    /**
     * Возвращает имя атрибута для поля формы
     * @param bool|int $index индекс модели при табличном вводе
     * @return string
     */

    protected function getFormAttrName($index)
    {

        return ($index !== false) ? "[$index]{$this->attr}" : $this->attr;

    }

    /**
     * Конфигурация поля для грида (GridView)
     * @return array
     */
    public function grid()
    {

        $grid = ['attribute' => $this->attr];

        if ($this->showInFilter)
            $grid['filter'] = $this->getGridFilter();

        if ($this->editInGrid) {

            $grid = array_merge($grid, $this->xEditable());

        }

        return $grid;

    }

    /**
     * Возвращает значение фильтра для грида
     * @return mixed
     */

    public function getGridFilter()
    {

        if ($this->gridFilter !== null) {
            return $this->gridFilter;
        } else {
            return $this->defaultGridFilter();
        }

    }

    /**
     * @param $value mixed установка значения фильтра
     */

    public function setGridFilter($value)
    {

        $this->gridFilter = $value;

    }

    /**
     * Возвращает значение фильтра для по умолчанию
     * @return mixed
     */

    protected function defaultGridFilter()
    {

        return true;

    }

    public function xEditable()
    {

        return [

            'class' => \mcms\xeditable\XEditableColumn::className(),
            'url' => $this->getEditableUrl(),
            'format' => 'raw',
        ];

    }

    /**
     * Создает url для x-editable
     * @return string
     */

    public function getEditableUrl()
    {

        return Yii::$app->urlManager->createUrl(Yii::$app->controller->uniqueId . "/" . $this->editableAction);

    }

    /**
     * Конфигурация полядля детального просмотра
     * @return array
     */
    public function view()
    {

        $view = ['attribute' => $this->attr];

        return $view;

    }

    /**
     * Правила валидации
     * @return array
     */

    public function rules()
    {

        $rules = [];

        if ($this->isSafe)
            $rules[] = [$this->attr, 'safe'];

        if ($this->isRequired)
            $rules[] = [$this->attr, 'required', 'except' => ActiveRecord::SCENARIO_SEARCH];

        return $rules;

    }

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {

        return [];

    }

    /**
     * Поиск
     * @param ActiveQuery $query запрос
     */

    public function search(ActiveQuery $query)
    {

        if ($this->search)
            $query->andFilterWhere([$this->attr => $this->model->{$this->attr}]);

    }

}
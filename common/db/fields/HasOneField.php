<?php
namespace common\db\fields;

use common\db\ActiveQuery;
use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class HasOneField
 * Поле для связей Has One. Интерфейс привязки в форме в виде выпадающего списка.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HasOneField extends ListField
{

    /**
     * @var bool жадная загрузка
     */
    public $eagerLoading = false;

    /**
     * @var string имя связи
     */
    public $relation;

    /**
     * @var string имя атрибута связанной модели отображаемого в гриде
     */
    public $gridAttr = "title";

    /**
     * @inheritdoc
     */
    public $numeric = true;

    /**
     * @var проверять наличие связанной модели
     */
    public $checkExist = true;

    /**
     * Конструктор
     * @param ActiveRecord $model модель
     * @param string $attr атрибут
     * @param string $relation имя Has One связи
     */
    public function __construct(ActiveRecord $model, $attr, $relation, $config = [])
    {

        $this->relation = $relation;

        parent::__construct($model, $attr, $config);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();

        if($this->checkExist) {

            $relation = $this->model->getRelation($this->relation);

            $isEmpty = function ($v) {
                return empty($v);
            };

            $rules[] = [$this->attr, 'exist', 'isEmpty' => $isEmpty, 'targetClass' => $relation->modelClass, 'targetAttribute' => key($relation->link), 'except' => [ActiveRecord::SCENARIO_SEARCH]];

        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    protected function grid()
    {

        $grid = $this->defaultGrid();

        $grid["value"] = function ($model, $index, $widget) {

            return ArrayHelper::getValue($model, "{$this->relation}.{$this->gridAttr}");

        };

        return $grid;

    }

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = $this->defaultView();

        $view["value"] = ArrayHelper::getValue($this->model, "{$this->relation}.{$this->gridAttr}");

        return $view;

    }

    /**
     * Поиск
     * @param ActiveQuery $query запрос
     */
    public function search(ActiveQuery $query)
    {
        parent::search($query);
        if($this->eagerLoading && $this->search) {
            $query->with($this->relation);
        }
    }


}
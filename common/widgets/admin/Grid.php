<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Grid
 * Грид для админки. Формируется на основе \common\db\MetaFields модели
 * @property array $rowButtons кнопки действий строк грида
 * @property array $groupButtons кнопки групповых операций
 * @property string $baseRoute базовая часть маршрута для формировнаия url действий
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Grid extends Widget
{

    /**
     * Преффикс идентификатора грида
     */

    const GRID_ID_PREF = "grid-";

    /**
     * Суфикс иденификатора виджета Pjax
     */

    const PJAX_SUF = "-pjax";

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var \yii\data\ActiveDataProvider провайдер данных
     */

    public $dataProvider;

    /**
     * @var string имя параметра передаваемого расширенным фильтром
     */
    public $extFilterParam = "extendedFilter";

    /**
     * @var array кнопки строк грида
     */

    protected $_rowButtons;

    /**
     * @var array дополнительные пользовательские колонки
     */

    public $userColumns = [];

    /**
     * @var bool вывод древовидных моделей
     */

    public $tree = false;
    /**
     * @var string шаблон
     */

    public $tpl = "grid";

    /**
     * @var string базовая часть маршрута к действиям
     */
    protected  $_baseRoute;

    /**
     * @var array кнопки групповых операций
     */
    protected $_groupButtons;

    /**
     * @var string идентификатор виджета
     */

    protected $id;
    /**
     * @var string идентификатор виджета PJAX
     */

    protected $pjaxId;

    /**
     * @return string
     */
    public function getBaseRoute()
    {

        if($this->_baseRoute === null)
            $this->_baseRoute = "/" . $this->view->context->uniqueId;

        return $this->_baseRoute;
    }

    /**
     * @param string $baseRoute
     */
    public function setBaseRoute($baseRoute)
    {
        $this->_baseRoute = $baseRoute;
    }

    /**
     * @return array
     */
    public function getRowButtons()
    {
        if($this->_rowButtons === null) {

            $this->_rowButtons = $this->defaultRowButtons();

        }

        return $this->_rowButtons;
    }

    /**
     * @param array $rowButtons
     */
    public function setRowButtons($rowButtons)
    {
        $this->_rowButtons = ArrayHelper::merge($this->defaultRowButtons(), $rowButtons);
    }




    public function init()
    {

        $model = $this->model;

        $this->id = strtolower(self::GRID_ID_PREF . str_replace("\\", "-", $model::className()));

        $this->pjaxId = $this->id . self::PJAX_SUF;

        $this->view->registerCss(".grid-checkbox-disabled input[type='checkbox'] { display:none; }");

    }

    /**
     * Запуск виджета
     * @return string|void
     */

    public function run()
    {

        return $this->render($this->tpl, [
            "model" => $this->model,
            "dataProvider" => $this->dataProvider,
            "columns" => $this->getColumns(),
            "groupButtons" => $this->getGroupButtons(),
            "id" => $this->id,
            "pjaxId" => $this->pjaxId,
        ]);

    }

    /**
     * Возвращает описание колонок
     * @return array
     */

    protected function getColumns()
    {

        $columns = [

            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => function ($model, $key, $index, $gridView) {
                    $arr = [];

                    $perm = $model->getPermission();

                    if ($perm AND !$perm->updateModel($model) AND !$perm->deleteModel($model))
                        $arr = ["class" => "grid-checkbox-disabled"];

                    return $arr;
                }
            ],

        ];

        $fields = $this->model->getMetaFields()->getFields();

        foreach ($fields AS $field) {

            $grid = $field->getGrid();

            if ($field->showInGrid AND $grid)
                $columns[] = $grid;

        }

        $columns = ArrayHelper::merge($columns, $this->userColumns);

        $columns[] = $this->getRowButtons();

        return $columns;

    }

    /**
     * Возвращает настройки по умолчанию кнопок действий над моделями
     * @return array
     */

    public function defaultRowButtons()
    {

        $js = function ($u) {

            return '$.get("' . $u . '", function(){ $.pjax.reload({container: "#' . $this->pjaxId . '", timeout: false}); }); return false;';

        };

        $buttonsTree = [

            'up' => function ($url, $model) use ($js) {

                $url = Url::toRoute([$this->baseRoute . '/up', 'id'=>$model->id]);

                if (Yii::$app->user->can('updateModel', ['model'=>$model]))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-arrow-up']), ['data-pjax' => 0, 'onClick' => $js($url), 'href' => '#', 'title' => Yii::t('core', 'Up')]);

            },

            'down' => function ($url, $model) use ($js) {

                $url = Url::toRoute([$this->baseRoute . '/down', 'id'=>$model->id]);

                if (Yii::$app->user->can('updateModel', ['model'=>$model]))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-arrow-down']), ['data-pjax' => 0, 'onClick' => $js($url), 'href' => '#', 'title' => Yii::t('core', 'Down')]);

            },

            'enter' => function ($url, $model) {

                $url = Url::toRoute(["/".Yii::$app->controller->route, "parent_id" => $model->id]);

                if (Yii::$app->user->can('readModel', ['model'=>$model]))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-open']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'Enter')]);

            },
        ];

        $buttonsDefault = [

            'view' => function ($url, $model) use ($js) {

                $url = Url::toRoute([$this->baseRoute . '/view', 'id'=>$model->id]);

                if (Yii::$app->user->can('readModel', ['model'=>$model]))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'View')]);

            },

            'update' => function ($url, $model) use ($js) {

                $url = Url::toRoute([$this->baseRoute . '/update', 'id'=>$model->id]);

                if (Yii::$app->user->can('updateModel', ['model'=>$model]))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'Update')]);

            },

            'delete' => function ($url, $model) use ($js) {

                $url = Url::toRoute([$this->baseRoute . '/delete', 'id'=>$model->id]);

                if (Yii::$app->user->can('deleteModel', ['model'=>$model]))
                    return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), $url, ['data-pjax' => 0, 'data-method' => 'post', 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'), 'title' => Yii::t('core', 'Delete')]);

            },

        ];

        if ($this->tree) {

            return [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{up} {down} {enter} {view} {update} {delete}',
                'buttons' => array_merge($buttonsTree, $buttonsDefault),
            ];

        } else {

            return [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => $buttonsDefault,
            ];

        }

    }

    /**
     * Возвращает массив кнопок групповых операций
     * @return arr
     */

    public function getGroupButtons()
    {

        if ($this->_groupButtons === null) {

            $this->_groupButtons = $this->defaultGroupButtons();

        }

        return $this->_groupButtons;

    }

    /**
     * Установка кнопок групповых операций
     * @param array $buttons параметры виджетов кнопок
     * [
     *  "delete"=>[
     *      "class"=>\common\widgets\admin\ActionButton::getClass(),
     *      "label"=>Yii::t("core", "Delete"),
     *      "url"=>"groupdelete",
     *  ],
     * ]
     */
    public function setGroupButtons(Array $buttons)
    {

        $this->_groupButtons = ArrayHelper::merge($this->defaultGroupButtons(), $buttons);

    }

    /**
     * Кнопки групповых операций по умолчанию
     * @return array
     */

    protected function defaultGroupButtons()
    {

        $model = $this->model;

        $arr = [

            "delete" => [
                "class" => \common\widgets\admin\ActionButton::className(),
                "label" => Yii::t('core', 'Delete'),
                "visible" => Yii::$app->user->can('deleteModels', ['model'=>$model]),
                "options" => [
                    'id' => 'group-delete',
                    'class' => 'btn btn-danger',
                ],
                "route" => $this->baseRoute . "/groupdelete",
            ],

        ];

        if ($this->tree AND !Yii::$app->request->get($this->extFilterParam)) {

            $arr["replace"] = [

                "class" => \common\widgets\admin\ReplaceInTreeButton::className(),
                "visible" =>  Yii::$app->user->can('updateModels', ['model'=>$model]),
                "label" => Yii::t('core', 'Replace'),
                "options" => [
                    'id' => 'group-replace',
                    'class' => 'btn btn-primary',
                ],
                "optionsOk" => [
                    'id' => 'group-replace-ok',
                    'class' => 'btn btn-primary',
                ],
                "route" => $this->baseRoute . "/replace",

            ];

        }

        return $arr;

    }

}
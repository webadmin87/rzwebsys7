<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Grid
 * Грид для админки. Формируется на основе \common\db\MetaFields модели
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
     * @var array кнопки строк грида
     */

    public $rowButtons = [];

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
     * @var array кнопки групповых операций
     */

    protected $groupButtons;
    /**
     * @var string идентификатор виджета
     */

    protected $id;
    /**
     * @var string идентификатор виджета PJAX
     */

    protected $pjaxId;

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

        $columns[] = ArrayHelper::merge($this->getDefaultRowButtons(), $this->rowButtons);

        return $columns;

    }

    /**
     * Возвращает настройки по умолчанию кнопок действий над моделями
     * @return array
     */

    public function getDefaultRowButtons()
    {

        $js = function ($u) {

            return '$.get("' . $u . '", function(){ $.pjax.reload({container: "#' . $this->pjaxId . '", timeout: false}); }); return false;';

        };

        $buttonsTree = [

            'up' => function ($url, $model) use ($js) {

                $perm = $model->getPermission();

                if (!$perm)
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-arrow-up']), ['data-pjax' => 0, 'onClick' => $js($url), 'href' => '#', 'title' => Yii::t('core', 'Up')]);

            },

            'down' => function ($url, $model) use ($js) {

                $perm = $model->getPermission();

                if (!$perm)
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-arrow-down']), ['data-pjax' => 0, 'onClick' => $js($url), 'href' => '#', 'title' => Yii::t('core', 'Down')]);

            },

            'enter' => function ($url, $model) {

                $url = Yii::$app->urlManager->createUrl([Yii::$app->controller->route, "parent_id" => $model->id]);

                $perm = $model->getPermission();

                if (!$perm OR $perm->readModel($model))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-open']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'Enter')]);

            },
        ];

        $buttonsDefault = [

            'view' => function ($url, $model) use ($js) {

                $perm = $model->getPermission();

                if (!$perm OR $perm->readModel($model))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'View')]);

            },

            'update' => function ($url, $model) use ($js) {

                $perm = $model->getPermission();

                if (!$perm OR $perm->updateModel($model))
                    return Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), ['data-pjax' => 0, 'href' => $url, 'title' => Yii::t('core', 'Update')]);

            },

            'delete' => function ($url, $model) use ($js) {

                $perm = $model->getPermission();

                if (!$perm OR $perm->deleteModel($model))
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
     * @return array
     */

    public function getGroupButtons()
    {

        if ($this->groupButtons !== null) {
            return $this->groupButtons;
        } else {
            return $this->defaultGroupButtons();
        }

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

        $this->groupButtons = ArrayHelper::merge($this->defaultGroupButtons(), $buttons);

    }

    /**
     * Кнопки групповых операций по умолчанию
     * @return array
     */

    protected function defaultGroupButtons()
    {

        $perm = $this->model->getPermission();

        $arr = [

            "delete" => [
                "class" => \common\widgets\admin\ActionButton::className(),
                "label" => Yii::t('core', 'Delete'),
                "visible" => !$perm OR $perm->deleteModels(),
                "options" => [
                    'id' => 'group-delete',
                    'class' => 'btn btn-danger',
                ],
                "route" => $this->view->context->uniqueId . "/groupdelete",
            ],

        ];

        if ($this->tree) {

            $arr["replace"] = [

                "class" => \common\widgets\admin\ReplaceInTreeButton::className(),
                "visible" => !$perm OR $perm->updateModels(),
                "label" => Yii::t('core', 'Replace'),
                "options" => [
                    'id' => 'group-replace',
                    'class' => 'btn btn-primary',
                ],
                "optionsOk" => [
                    'id' => 'group-replace-ok',
                    'class' => 'btn btn-primary',
                ],
                "route" => $this->view->context->uniqueId . "/replace",

            ];

        }

        return $arr;

    }

}
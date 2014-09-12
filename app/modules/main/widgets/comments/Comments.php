<?php
namespace app\modules\main\widgets\comments;

use app\modules\main\models\Comments as Model;
use common\db\ActiveRecord;
use common\db\TActiveRecord;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

/**
 * Class Comments
 * Виджет добавления комментариев
 * @package app\modules\main\widgets\comments
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Comments extends Widget
{

    /**
     * @var string класс модели
     */
    public $modelClass;

    /**
     * @var int идентификатор элемента
     */
    public $itemId;

    /**
     * @var int шаг смещения вложенных комментариев
     */

    public $marginStep = 20;

    /**
     * @var int количество комментариев на одной странице. 0 - нет пагинации
     */

    public $pageSize = 0;

    /**
     * @var callable функция для преобразования запроса. Принимает аргумент \common\db\ActiveQuery
     */

    public $queryModifier;

    /**
     * @var array дополнительная конфигурация провайдера данных
     */

    public $dataProviderConfig = [];

    /**
     * @var string шаблон
     */

    public $tpl = "index";

    /**
     * @var array атрибуты формы
     */

    public $formOptions = [];

    /**
     * @var string маршрут добавления комментария
     */

    public $actionRoute = "/main/comments/add";

    /**
     * @var string имя класса виджета редактора комментариев
     */

    public $editorClass = "\\common\\widgets\\markitup\\MarkItUp";

    /**
     * @var array настройки виджета редактора
     */

    public $editorOptions = [];

    /**
     * @var \yii\web\AssetBundle ассет скина
     */

    protected $_skinAsset;

    /**
     * @var ActiveDataProvider провайдер данных
     */

    protected $dataProvider;

    /**
     * Возвращает ассет скина
     * @return \yii\web\AssetBundle
     */

    public function getSkinAsset()
    {

        if ($this->_skinAsset === null) {

            $this->_skinAsset = \app\modules\main\widgets\comments\SkinAsset::className();

        }

        return $this->_skinAsset;

    }

    /**
     * Установка ассета скина
     * @param \yii\web\AssetBundle $val
     */

    public function setSkinAsset($val)
    {

        $this->_skinAsset = $val;

    }

    /**
     * @inheritdoc
     */

    public function init()
    {

        $skin = $this->skinAsset;

        if ($skin)
            $skin::register($this->view);

        CommentsAsset::register($this->view);

        $parent = Model::findOne(TActiveRecord::ROOT_ID);

        $query = $parent->descendants()->published()->andWhere(["model" => $this->modelClass, "item_id" => $this->itemId]);

        if (is_callable($this->queryModifier)) {

            $func = $this->queryModifier;

            $func($query);

        }

        $config = array_merge([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ], $this->dataProviderConfig);

        $this->dataProvider = Yii::createObject($config);

        $this->dataProvider->getPagination()->pageSize = $this->pageSize;

        $id = $this->getId();

        $this->view->registerJs("$('#$id').commentsWidget()");

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        $model = Yii::createObject(["class" => Model::className(), "scenario" => ActiveRecord::SCENARIO_INSERT]);

        $model->model = $this->modelClass;

        $model->item_id = $this->itemId;

        $formOptions = array_merge([
            "enableClientValidation" => true,
            "enableAjaxValidation" => false,
            "validateOnSubmit" => true,
            "action" => Yii::$app->urlManager->createUrl($this->actionRoute)
        ], $this->formOptions);

        return $this->render($this->tpl, [
            "model" => $model,
            "dataProvider" => $this->dataProvider,
            "marginStep" => $this->marginStep,
            "formOptions" => $formOptions,
            "editorClass" => $this->editorClass,
            "editorOptions" => $this->editorOptions,
            "id" => $this->getId(),
        ]);

    }

}
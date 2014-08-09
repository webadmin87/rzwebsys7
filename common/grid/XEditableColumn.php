<?php

namespace common\grid;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use \mcms\xeditable\XEditableConfig;
use \mcms\xeditable\XEditableAsset;

use yii\helpers\Json;

/**
 * Class XEditableColumn
 * Колонка редактирования данных в гриде
 * Исправляет баги оригинально расширения.
 * @package common\grid\xeditable
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class XEditableColumn extends DataColumn
{
    /**
     * @var array defaults for editable configuration
     */
    public $pluginOptions = [];

    public $dataType = 'text';
    public $pk='id';
    public $dataTitle = '';
    public $editable = null;
    private $view = null;
    public $url = null;

    protected $_id;

    /**
     * Возвражает уникальный идентификатор колонки
     * @return string
     */
    public function getId()
    {
        if($this->_id === null)
        {
            $this->_id = "editable-".uniqid(rand());
        }

        return $this->_id;

    }

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * @inheritdoc
     */
    protected function getDataCellContent($model, $key, $index)
    {
        if (empty($this->url)) {
            $this->url = \Yii::$app->urlManager->createUrl($_SERVER['REQUEST_URI']);
        }

        if (empty($this->value)) {
            $value = ArrayHelper::getValue($model, $this->attribute);
        } else {
            $value = call_user_func($this->value, $model, $index, $this);
        }

        $value = '<a href="#" data-name="'.$this->attribute.'" data-value="' . $model->{$this->attribute} . '"  class="editable '.$this->id.'" data-type="' . $this->dataType . '" data-pk="' . $model->{$this->pk} . '" data-url="' . $this->url . '" data-title="' . $this->dataTitle . '">' . $value . '</a>';

        return $value;
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return $this->grid->formatter->format($this->getDataCellContent($model, $key, $index), $this->format);
    }

    /**
     * @inheritdoc
     */
    public function registerAssets()
    {
        $config = new XEditableConfig();

        if(isset($this->pluginOptions['mode']) && is_array($this->pluginOptions)){
            $config->mode = $this->pluginOptions['mode'];
        }

        if(isset($this->pluginOptions['form']) && is_array($this->pluginOptions)){
            $config->form = $this->pluginOptions['form'];
        }

        $config->registerDefaultAssets();

        $this->view = \Yii::$app->getView();
        XEditableAsset::register($this->view);
        $this->editable = Json::encode($this->editable);
        $this->view->registerJs('$(".'.$this->id.'").editable(' . $this->editable . ');');
    }

} 
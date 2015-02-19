<?php
namespace common\widgets;

use vova07\select2\Widget;
use yii\helpers\Html;
use yii\jui\JuiAsset;

/**
 * Class SortedTags
 * Реализует выбор тегов из выпадающего списка с возможностью их сортировки. Формирует данные в виде строки вида "#id название"
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SortedTags extends Widget
{

    public $bootstrap = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->settings["tags"] = $this->getTagsData($this->items);

    }

    /**
     * @inheritdoc
     */
    public function registerClientScript()
    {
        parent::registerClientScript();

        JuiAsset::register($this->view);

        $id = $this->options["id"];

        $this->view->registerJs("

	    $('#$id').select2('container').find('ul.select2-choices').sortable({
            containment: 'parent',
            start: function() { $('#$id').select2('onSortStart'); },
            update: function() { $('#$id').select2('onSortEnd'); }
        });
        ");

    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::hiddenInput($this->name, $this->value, $this->options);
        }
    }

    /**
     * Возвращает массив строк, каждая из которых содеожит id и названия
     * @param array $data данные передаваемые в выпадающий список
     * @return array
     */
    public function getTagsData($data) {

        $arr = [];

        foreach($data AS $id => $title)
            $arr[] = sprintf("#%s %s", $id, $title);

        return $arr;

    }


} 
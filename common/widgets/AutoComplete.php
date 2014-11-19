<?php
namespace common\widgets;

use yii\jui\AutoComplete as Base;
use yii\helpers\Html;
use yii;
use yii\web\JsExpression;

/**
 * Class AutoComplete
 * Виджет автозаполнения. Данные сохраняются в скрытое поле. Позволяет делать привязку по идентификатору.
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AutoComplete extends Base
{

    /**
     * @var string атрибут для отображения в поле автокомплита, если не задан берется атрибут для скрытого поля
     */
    public $visibleAttribute;

    /**
     * @var string значение для отображения в поле автокомплита, если не задано берется значение для скрытого поля
     */
    public $visibleValue;

    /**
     * @var array html атрибуты поля автокомплита.
     */
    public $visibleOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!isset($this->visibleOptions["id"])) {

            $this->visibleOptions["id"] = $this->options["id"] . "-visible";

        }

        if(empty($this->clientOptions['select'])) {

            $this->clientOptions['select'] = new JsExpression("function(event, ui) {

                    var hiddenVal = ui.item.id ? ui.item.id : ui.item.value;

                    $('#{$this->options["id"]}').val(hiddenVal);

            }");

        }

        if(empty($this->clientOptions['change'])) {

            $this->clientOptions['change'] = new JsExpression("function(event, ui) {

                    var val = $(event.currentTarget).val();

                    if(!val)
                        $('#{$this->options["id"]}').val('');

            }");

        }

        if($this->hasModel() AND $this->visibleAttribute === null) {

            $this->visibleAttribute = $this->attribute;

        } elseif($this->visibleValue === null) {

            $this->visibleValue = $this->value;

        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        echo $this->renderWidget();
        $this->registerWidget('autocomplete', $this->visibleOptions["id"]);

    }


    /**
     * Renders the AutoComplete widget.
     * @return string the rendering result.
     */
    public function renderWidget()
    {
        if ($this->hasModel()) {
            $html = Html::activeTextInput($this->model, $this->visibleAttribute, $this->visibleOptions);
            $html .= Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            $html = Html::textInput($this->name, $this->visibleValue, $this->options);
            $html .= Html::hiddenInput($this->name, $this->value, $this->options);
        }

        return $html;

    }

}
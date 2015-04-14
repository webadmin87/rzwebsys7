<?php

namespace common\widgets;

use common\web\JqueryNumberAsset;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class FormattedNumberInput
 * Виджет ввода чисел с форматированием
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class FormattedNumberInput extends InputWidget
{

    /**
     * @var string разделитель десятичной части
     */
    public $decimalSep = ".";

    /**
     * @var string разделитель тысяч
     */
    public $thousandSep = " ";

    /**
     * @var int количество знаков после запятой
     */
    public $decimals = 0;

    /**
     * @var string
     */
    protected $hiddenId;

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {

        parent::init();

        JqueryNumberAsset::register($this->view);

        $this->hiddenId = $this->options["id"]."-hidden";

        $this->view->registerJs("

            ;(function() {

                $('#{$this->options["id"]}').number( true, {$this->decimals}, '{$this->decimalSep}', '{$this->thousandSep}' );

                $('#{$this->options["id"]}').on('blur', function(){

                    $('#{$this->hiddenId}').val($(this).val());

                });

            })();

        ");


    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        $html = "";

        if ($this->hasModel()) {
            $html .= Html::activeTextInput($this->model, $this->attribute, $this->options);
            $html .= Html::activeTextInput($this->model, $this->attribute, ["id"=>$this->hiddenId,"style"=>"display: none"]);
        } else {
            $html .= Html::textInput($this->name, $this->value, $this->options);
            $html .= Html::textInput($this->name, $this->value, ["id"=>$this->hiddenId,"style"=>"display: none"]);
        }

        return $html;

    }


}
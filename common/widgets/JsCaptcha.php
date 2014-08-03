<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class JsCaptcha
 * Втджет JS капчи
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class JsCaptcha extends InputWidget
{

    /**
     * @inheritdoc
     */

    public function init()
    {
        parent::init();
        $this->view->registerJs("
            $('#{$this->options['id']}').val('{$this->value}');
        ");
    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::hiddenInput($this->name, '', $this->options);
        }

    }

}
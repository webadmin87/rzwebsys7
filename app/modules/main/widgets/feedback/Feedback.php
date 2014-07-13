<?php

namespace app\modules\main\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class Feedback
 * Виджет формы обратной связи
 * @package app\modules\main\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Feedback extends Widget {

    /**
     * @var array маршрут отправки формы
     */

    public $route = ['/main/feedback/index'];

    /**
     * @var string класс модели
     */

    public $modelClass = '\app\modules\main\models\FeedbackForm';

    /**
     * @var array параметры формы \yii\widgets\ActiveForm
     */

    public $formOptions = [];

    /**
     * @var string шаблон
     */

    public $tpl = "index";

    /**
     * @var \app\modules\main\models\FeedbackForm модель формы
     */

    protected $model;

    /**
     * @inheritdoc
     */

    public function init() {

        $this->model = Yii::createObject($this->modelClass);

    }

    /**
     * @inheritdoc
     */

    public function run() {

        $formOptions = array_merge([
            "action" => Url::toRoute($this->route),
            "enableClientValidation"=>true,

        ], $this->formOptions);

        return $this->render($this->tpl, ["model"=>$this->model, "formOptions"=>$formOptions]);

    }

}
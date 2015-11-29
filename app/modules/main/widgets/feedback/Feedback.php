<?php

namespace app\modules\main\widgets\feedback;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class Feedback
 * Виджет формы обратной связи
 * @package app\modules\main\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Feedback extends Widget
{

    /**
     * @var array маршрут отправки формы
     */

    public $route = ['/main/service/feedback'];

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
     * @var string селектор для ссылки по которой открывать виджет обратной связи в fancybox. Если не задан форма выводится на странице
     */

    public $fancySelector;

    /**
     * @var array параметры fancybox
     * @link http://fancybox.net/api
     */
    public $fancyConfig = [];

    /**
     * @var \app\modules\main\models\FeedbackForm модель формы
     */

    protected $model;

    /**
     * @inheritdoc
     */

    public function init()
    {

        FeedbackAsset::register($this->view);

        $this->model = Yii::createObject($this->modelClass);

        $id = $this->getId();

        $url = Url::toRoute($this->route);

        $this->view->registerJs("$('#$id').feedbackWidget('$url')");

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        if ($this->fancySelector) {

            echo \newerton\fancybox\FancyBox::widget([
                'target' => $this->fancySelector,
                'config' => array_merge([
                    'href' => '#' . $this->getId(),
                    'autoDimensions' => false,
                    'autoSize' => false,
                    'width' => 560,
                    'type' => 'inline',
                ], $this->fancyConfig),
            ]);

        }

        $formOptions = array_merge([
            "action" => Url::toRoute($this->route),
            "enableClientValidation" => true,
            "enableAjaxValidation" => false,
            "validateOnSubmit" => true,

        ], $this->formOptions);

        return $this->render($this->tpl, ["id" => $this->getId(), "model" => $this->model, "formOptions" => $formOptions, "hidden" => !empty($this->fancySelector)]);

    }

}
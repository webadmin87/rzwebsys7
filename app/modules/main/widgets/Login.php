<?php
namespace app\modules\main\widgets;

use yii\base\Widget;

/**
 * Class Login
 * Виджет формы логина
 * @package app\modules\main\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Login extends Widget
{

    /**
     * @var \app\modules\main\models\LoginForm модель формы
     */

    public $model;

    /**
     * @var array параметры формы
     */

    public $formOptions = [];

    /**
     * @var string шаблон
     */

    public $tpl = "login";

    /**
     * @inheritdoc
     */

    public function run()
    {

        $formOptions = array_merge(['id' => $this->getId()], $this->formOptions);

        return $this->render($this->tpl, ["model" => $this->model, "formOptions" => $formOptions]);

    }

}

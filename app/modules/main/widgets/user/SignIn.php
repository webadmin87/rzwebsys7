<?php
namespace app\modules\main\widgets\user;

use yii\base\Widget;

/**
 * Class SignIn
 * Виджет формы логина
 * @package app\modules\main\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SignIn extends Widget
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
    public $tpl = "sign-in";

    /**
     * @inheritdoc
     */
    public function run()
    {

        $formOptions = array_merge(['id' => $this->getId()], $this->formOptions);

        return $this->render($this->tpl, ["model" => $this->model, "formOptions" => $formOptions]);

    }

}

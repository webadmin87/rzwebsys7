<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\bootstrap\BootstrapPluginAsset;

/**
 * Class Form
 * Форма модели для админки. Формируется на основе \common\db\MetaFields модели
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Form extends Widget
{

    /**
     * Преффикс идентификатора виджета
     */

    const FORM_ID_PREF = "form-";

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var array параметры \yii\widgets\ActiveForm
     */

    public $formOptions = [];

    /**
     * @var string шаблон
     */

    public $tpl = "form";

    /**
     * @var array параметры \yii\widgets\ActiveForm по умолчанию
     */

    protected $defaultFormOptions = ['enableAjaxValidation' => true, 'enableClientValidation' => false];

    /**
     * @var string идентификатор виджета
     */

    protected $id;

    public function init()
    {

        $model = $this->model;

        $this->id = strtolower(self::FORM_ID_PREF . str_replace("\\", "-", $model::className()));

        BootstrapPluginAsset::register($this->view);

    }

    public function run()
    {

        $formOptions = array_merge($this->defaultFormOptions, $this->formOptions);

        return $this->render($this->tpl, [
                "model" => $this->model,
                "formOptions" => $formOptions,
                "id" => $this->id,
            ]
        );

    }

}
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
    
    /**
     * @var директория с шаблонами
     */
    protected $_tplDir;

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
    
        /**
     * @var array директории, где хранятся шаблоны
     */
    public function getTplDir()
    {
        if ($this->_tplDir === null) {

            $widgetTpl = [$this->viewPath . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR];

            if (is_array($this->model->tplDir)) {
                foreach ($this->model->tplDir as $dir) {
                    $modelTpl[] = Yii::getAlias($dir);
                }
            } else {
                $modelTpl = [Yii::getAlias($this->model->tplDir)];
            }

            $this->_tplDir = ArrayHelper::merge($modelTpl, $widgetTpl);
        }

        return $this->_tplDir;
    }

    /**
     * @var string шаблон для вкладки формы
     */
    public function getTplFile($key = 'default')
    {
        foreach($this->tplDir as $dir){
            $file = $dir . $key . '.tpl';
            if (is_file($file)) return file_get_contents($file);
        };
        return false;
    }

}

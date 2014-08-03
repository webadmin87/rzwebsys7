<?php
namespace common\widgets\markitup;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class MarkItUp
 * Виджет редактора MarkItUp
 * @package common\widgets\markitup
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class MarkItUp extends InputWidget
{

    /**
     * @var string идентификатор настроек
     */

    public $markItUpSet = "bbcode";

    /**
     * @var \yii\web\AssetBundle ассет скина
     */

    protected $_skinAsset;

    /**
     * @var \yii\web\AssetBundle ассет настроек
     */

    protected $_setAsset;

    /**
     * Возвращает ассет скина
     * @return \yii\web\AssetBundle
     */

    public function getSkinAsset()
    {

        if ($this->_skinAsset === null) {

            $this->_skinAsset = \common\widgets\markitup\SkinSimpleAsset::className();

        }

        return $this->_skinAsset;

    }

    /**
     * Установка ассета скина
     * @param \yii\web\AssetBundle $val
     */

    public function setSkinAsset($val)
    {

        $this->_skinAsset = $val;

    }

    /**
     * Получения ассета настроек
     * @return \yii\web\AssetBundle
     */

    public function getSetAsset()
    {

        if ($this->_setAsset === null) {

            $this->_setAsset = \common\widgets\markitup\SetBbCodeAsset::className();

        }

        return $this->_setAsset;

    }

    /**
     * Установка ассета настроек
     * @param \yii\web\AssetBundle $val
     */

    public function setSetAsset($val)
    {

        $this->_setAsset = $val;

    }

    /**
     * @inheritdoc
     */

    public function init()
    {

        parent::init();

        $skin = $this->skinAsset;

        $set = $this->setAsset;

        $skin::register($this->view);

        $set::register($this->view);

        $id = $this->options['id'];

        $this->view->registerJs("

			$('#{$id}').markItUp({$this->markItUpSet}MarkItUpSettings);

        ");

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        if ($this->hasModel()) {

            return Html::activeTextarea($this->model, $this->attribute, $this->options);

        } else {

            return Html::textarea($this->name, $this->value, $this->options);

        }

    }

}
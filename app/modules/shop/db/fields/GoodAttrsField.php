<?php
namespace app\modules\shop\db\fields;

use Yii;
use common\db\fields\Field;
use yii\helpers\Html;

/**
 * Class GoodAttrsField
 * Поле для отображения связанных с заказанным товаром атрибутов
 * @package app\modules\shop\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class GoodAttrsField extends Field
{

    public $showInGrid = false;

    public $showInForm = false;

    public $showInFilter = false;

    public $showInExtendedFilter = false;

    public $showInTableInput = false;

    /**
     * @inheritdoc
     */
    public function view()
    {

        return ["attribute"=>$this->attr, 'format'=>'html', 'value'=>$this->renderGoodAttrs()];

    }

    /**
     * Рендер таблицы с атрибутами
     * @return null|string
     * @throws \yii\base\InvalidConfigException
     */
    protected function renderGoodAttrs()
    {

        $attr = $this->attr;

        $html = null;

        $value = $this->model->$attr;

        if(empty($value) OR !is_array($value))
            return $html;

        $class = $this->model->item_class;

        if(class_exists($class))
            $o = Yii::createObject($class);

        $html .= Html::beginTag('table', ['class'=>'table']);

        foreach($value AS $k=>$v) {

            $label = !empty($o)?$o->getAttributeLabel($k):$k;

            $td = Html::tag('td', $label) . Html::tag('td', $v);

            $html .= Html::tag('tr', $td);

        }

        $html .= Html::endTag('table');

        return $html;


    }

}
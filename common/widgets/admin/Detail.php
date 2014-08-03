<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;

/**
 * Class Detail
 * Виджет детального просмотра. Формируется на основе \common\db\MetaFields модели
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Detail extends Widget
{

    /**
     * Преффикс идентификатора виджета
     */

    const DETAIL_ID_PREF = "detail-";

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var string шаблон
     */

    public $tpl = "detail";

    /**
     * @var string идентификатор виджета
     */

    protected $id;

    /**
     * @inheritdoc
     */

    public function init()
    {

        $model = $this->model;

        $this->id = strtolower(self::DETAIL_ID_PREF . str_replace("\\", "-", $model::className()));

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        return $this->render($this->tpl, [
                "model" => $this->model,
                "attributes" => $this->getAttributes(),
                "id" => $this->id,
            ]
        );

    }

    /**
     * Возвращает описание полей
     * @return array
     */

    protected function getAttributes()
    {

        $fields = $this->model->getMetaFields()->getFields();

        foreach ($fields AS $field) {

            $view = $field->view();

            if ($field->showInView AND $view)
                $attrs[] = $view;

        }

        return $attrs;

    }

}
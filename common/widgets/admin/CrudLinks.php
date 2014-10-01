<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class CrudLinks
 * Класс для отображения ссылок на CRUD действия
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CrudLinks extends Widget
{

    /**
     * Константы CRUD действий
     */

    const CRUD_LIST = "list";

    const CRUD_VIEW = "view";

    /**
     * @var string действие для которого отобразить кнопки (self::CRUD_LIST|self::CRUD_VIEW)
     */

    public $action;

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var array массив дополнительных параметров для url
     */

    public $urlParams = [];

    /**
     * @inheritdoc
     */

    public function run()
    {

        $buttons = $this->getButtons()[$this->action];

        $html = '';

        foreach ($buttons AS $button) {

            if (Yii::$app->user->can($button['permission'], ['model' => $this->model]))
                $html .= Html::a($button["label"], $button["url"], $button["options"]) . "\n";

        }

        return $html;

    }

    /**
     * Возвращает описание ссылок
     * @return array
     */

    public function getButtons()
    {

        return $buttons = [

            self::CRUD_LIST => [

                [
                    'label' => Yii::t('core', 'Create'),
                    'url' => array_merge(['create'], $this->urlParams),
                    'options' => ['class' => 'btn btn-success'],
                    'permission' => 'createModels',
                ]

            ],

            self::CRUD_VIEW => [

                [
                    'label' => Yii::t('core', 'Update'),
                    'url' => array_merge(['update', 'id' => $this->model->id], $this->urlParams),
                    'options' => ['class' => 'btn btn-primary'],
                    'permission' => 'updateModel',
                ],

                [
                    'label' => Yii::t('core', 'Delete'),
                    'url' => array_merge(['delete', 'id' => $this->model->id], $this->urlParams),
                    'options' => ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('core', 'Are you sure?'),
                            'method' => 'post',
                        ],
                    ],
                    'permission' => 'deleteModel',
                ],

            ],

        ];

    }

}
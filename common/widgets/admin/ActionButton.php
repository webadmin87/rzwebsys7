<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class ActionButton
 * Кнопка групповых действий над элементами грида \common\widgets\admin\Grid
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ActionButton extends Widget
{

    /**
     * Преффикс идентификатора видета
     */

    const ID_PREF = "button-";

    /**
     * @var string текст на кнопке
     */

    public $label;

    /**
     * @var string route маршрут для отправки формы
     */

    public $route;

    /**
     * @var array html атрибуты кнопки
     */

    public $options = [];

    /**
     * @var bool отображать ли данный виджет
     */

    public $visible = true;

    /**
     * @var string url на которую будет отправлена форма
     */

    protected $url;

    /**
     * @inheritdoc
     */

    public function init()
    {

        if (!$this->visible)
            return;

        $this->url = Yii::$app->urlManager->createUrl($this->route);

        if (empty($this->options["id"]))
            $this->options["id"] = static::ID_PREF . uniqid(rand());

        $this->registerJs();
    }

    /**
     * Регистрируем обработчика клика по кнопке
     */

    protected function registerJs()
    {

        $message = Yii::t('core', 'Are you shure?');

        $this->view->registerJs("

             $('#{$this->options["id"]}').on('click', function(){

                 if(confirm('$message')) {

                     var form = $(this).parents('form');

                     form.attr('action', '{$this->url}');

                     form.submit();

                 }

                 });

             ");

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        if (!$this->visible)
            return "";

        return Html::button($this->label, $this->options);

    }

}
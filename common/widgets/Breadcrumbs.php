<?php
namespace common\widgets;

use yii\helpers\Html;

/**
 * Class Breadcrumbs
 * Виджет хлебных крошек. Добавлена возможность передачи html атрибутов ссылкам, а также задания шаблона для подписи.
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{

    /**
     * @var array html атрибуты ссылок
     */
    public $linkOptions = [];

    /**
     * @var string шаблон подписи
     */
    public $labelTemplate = "{label}";

    /**
     * @var string шаблон подписи активного пункта
     */
    public $activeLabelTemplate = "{label}";

    /**
     * @inheritdoc
     */
    protected function renderItem($link, $template)
    {
        if (isset($link['label'])) {
            $label = $this->encodeLabels ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        $label = strtr(isset($link['url']) ? $this->labelTemplate : $this->activeLabelTemplate, ["{label}"=>$label]);

        $issetTemplate = isset($link['template']);
        if (isset($link['url'])) {
            return strtr($issetTemplate ? $link['template'] : $template, ['{link}' => Html::a($label, $link['url'], $this->linkOptions)]);
        } else {
            return strtr($issetTemplate ? $link['template'] : $template, ['{link}' => $label]);
        }
    }


}
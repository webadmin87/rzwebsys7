<?php
namespace app\modules\main\sitemap;

use Yii;
use yii\base\Component;
use common\db\TActiveQuery;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Sitemap
 * Компонет для генерации карты сайта
 * @package app\modules\main\sitemap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Sitemap extends Component
{

    /**
     * @var array массив определяющий сущности для карты сайта
     * [
     *  [
     *      "class"=>"app\modules\main\models\Pages",
     *      "entityLabel"=>function() { return 'News';},
     *      "entityRoute"=>"main/pages/index",
     *      "labelAttr"=>"title",
     *      "scopes" => ["active"],
     *      "urlCreate" => function($model){ ... }
     *      "doAdd" => function($model){ ... }
     *  ],
     *  ...
     * ]
     *
     * class, urlCreate - обязательные элементы
     *
     * если scopes не задано, применяется свойство $defaultScope
     * если labelAttr не задано, применяется свойство $defaultLabelAttr
     */
    public $definition;

    /**
     * @var string путь к файлу, куда сохранять карту сайта
     */
    public $sitemapPath = "@webapp/web/sitemap.xml";

    /**
     * @var string scope применяемый по умолчанию
     */
    public $defaultScope = "published";

    /**
     * @var string имя атрибута для вывода подписи по умолчанию
     */
    public $defaultLabelAttr = "title";

    /**
     * Возвращает массив скартой сайта
     * @return array
     * @throws InvalidConfigException
     */
    public function getElements()
    {

        $elements = [];

        foreach($this->definition AS $item) {

            if(empty($item["class"]) || empty($item["urlCreate"]))
                throw new InvalidConfigException("Class or url create function missing");

            $query = $item["class"]::find();

            $scopes = !empty($item["scopes"])?$item["scopes"]:[$this->defaultScope];

            $labelAttr = !empty($item["labelAttr"])?$item["labelAttr"]:$this->defaultLabelAttr;

            $this->applyScopes($query, $scopes);

            if($query instanceof TActiveQuery)
                $query->orderBy(["lft"=>SORT_ASC]);
            else
                $query->orderBy(["id"=>SORT_DESC]);

            $iterator = $query->each();


            $arr = [];
            $arr['header'] = (!empty($item["entityLabel"]) && is_callable($item["entityLabel"]))?call_user_func($item["entityLabel"]):$item["class"]::getEntityName();
            if(!empty($item["entityRoute"]))
                $arr['entityUrl'] = Url::toRoute($item["entityRoute"]);
            $arr['items'] = [];

            foreach($iterator AS $model) {

                if(empty($model->$labelAttr) OR (!empty($item["doAdd"]) AND !call_user_func($item["doAdd"], $model)))
                    continue;

                $arr['items'][] = [
                    "label"=>$model->$labelAttr,
                    "url"=> Html::encode(call_user_func($item["urlCreate"],$model)),
                    "date"=>$model->updated_at,

                ];

            }

            $elements[] = $arr;

        }

        return $elements;

    }

    /**
     * Применяет scopes к запросу
     * @param \yii\db\ActiveQueryInterface $query запрос
     * @param array $scopes массив имен scopes
     */
    protected function applyScopes($query, $scopes)
    {

        foreach($scopes AS $scope) {
            $query->$scope();
        }

    }

    /**
     * Рендерит карту в xml и сохраняет в файл
     * @return int количество элемнтов добавленных в карту сайта
     * @throws InvalidConfigException
     */
    public function renderXml()
    {

        $path = Yii::getAlias($this->sitemapPath);

        $doc = new \DOMDocument('1.0', 'utf-8');

        $urlset = $doc->createElement('urlset');

        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $urlset->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

        $doc->appendChild($urlset);

        $elements = $this->getElements();

        $all = 0;

        foreach($elements AS $element) {

            foreach($element["items"] AS $item) {

                $this->addItem($doc, $item);

                $all++;

            }

        }

        $doc->save($path);

        return $all;

    }

    /**
     * Добавляет элемент в карту сайта
     * @param \DOMDocument $doc
     * @param array $params массив параметров. должен содержать ключи url, date
     */
    protected function  addItem($doc, $params)
    {

        $urlset = $doc->getElementsByTagName('urlset')->item(0);

        $url = $doc->createElement('url');

        $urlset->appendChild($url);

        $loc = $doc->createElement("loc", $params["url"]);

        $url->appendChild($loc);

        $priority = $doc->createElement("priority", '0.5');

        $url->appendChild($priority);

        $date = new \DateTime($params["date"]);

        $lastmod = $doc->createElement("lastmod", $date->format("Y-m-d"));

        $url->appendChild($lastmod);

    }



}
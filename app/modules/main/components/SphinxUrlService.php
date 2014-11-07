<?php
namespace app\modules\main\components;

use yii\base\Component;
use yii\helpers\Url;

/**
 * Class SphinxUrlService
 * Компонент для создание URL адресов результатов поиска сфинкса
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SphinxUrlService extends Component
{

    /**
     * @var string ключ массива результатов содержащий идентификатор модели
     */
    public $modelKey = "model";

    /**
     * Создание url
     * @param array $model массив результатов
     * @return string
     */
    public function createUrl(array $model)
    {

        switch($model[$this->modelKey]) {

            case "News":
                $url = Url::toRoute(["/news/news/detail", "code"=>$model["code"], "section"=>$model["section_code"]]);
                break;
            case "Pages":
                $m = \app\modules\main\models\Pages::findOne($model["item_id"]);
                if($m)
                    $url = Url::toRoute(["/main/pages/index", "model"=>$m]);
                else
                    $url = "";
                break;
            case "Catalog":
                $url = Url::toRoute(["/catalog/catalog/detail", "code"=>$model["code"], "section"=>$model["section_code"]]);
                break;
            default:
                $url="";

        }

        return $url;

    }


}
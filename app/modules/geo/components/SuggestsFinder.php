<?php
namespace app\modules\geo\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use app\modules\geo\models\Street;

/**
 * Class SuggestsFinder
 * Компонент формирования предположений для вывода в автокомплите
 * @package app\modules\geo\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SuggestsFinder extends Component
{


    /**
     * Возвращает предположения по улицам
     * @param string $term поисковая фраза
     * @param int $limit количество результатов
     * @return array
     */
    public function streetSuggests($term, $limit = 50)
    {

        $streets = Street::find()->with(['region', 'rajon'])->published()->andWhere(['~*', 'title', $term])->limit($limit)->all();

        $arr = [];

        foreach($streets AS $street) {

            $path = $this->getStreetPath($street);

            $arr[] = [
                'label'=>implode(",", $path['label']),
                'value'=>$street->title,
                'geo'=>$path['geo'],
            ];

        }

        return $arr;


    }

    /**
     * Формирует массив описывающий местоположение улицы
     * @param Street $street улица
     * @return array
     */
    public function getStreetPath(Street $street)
    {
        $labelArr[] = $street->clean_title;

        $geoArr = [];

        if($street->region) {

            $labelArr[] = ArrayHelper::getValue($street, 'region.title');

            $geoArr['region_id'] = ArrayHelper::getValue($street, 'region.id');

            $labelArr[] = ArrayHelper::getValue($street, 'region.country.title');

            $geoArr['country_id'] = ArrayHelper::getValue($street, 'region.country.id');

        } elseif($street->rajon) {

            $labelArr[] = ArrayHelper::getValue($street, 'rajon.title');

            $geoArr['rajon_id'] = ArrayHelper::getValue($street, 'rajon.id');

            $labelArr[] = ArrayHelper::getValue($street, 'rajon.region.title');

            $geoArr['region_id'] = ArrayHelper::getValue($street, 'rajon.region.id');

            $labelArr[] = ArrayHelper::getValue($street, 'rajon.region.country.title');

            $geoArr['country_id'] = ArrayHelper::getValue($street, 'rajon.region.country.id');
        }

        return ["label"=>array_reverse($labelArr), "geo"=>$geoArr];

    }

}
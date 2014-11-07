<?php
namespace app\modules\catalog\components;

use Yii;
use yii\base\Component;
use app\modules\catalog\models\Catalog;
use yii\data\ActiveDataProvider;

/**
 * Class FilterProvider
 * Провайдер фильров для публичной части
 * @package app\modules\catalog\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class FilterProvider extends Component
{

    /**
     * Возвращает провайдер данных
     * @param Catalog $model модель эелемента каталога
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function getDataProvider(Catalog $model)
    {

        $query = $model->find()->bySections($model->sectionsIds);

        $query->andFilterWhere($model->getAttributes());

        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ]);

        return $dataProvider;
    }

}
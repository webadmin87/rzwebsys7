<?php

namespace app\modules\catalog\models;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * Class CatalogSearch
 * Модель для фильтрации элементов каталога в публичной части
 * @package app\modules\catalog\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogSearch extends Catalog
{


    /**
     * Возвращает провайдер данных
     * @return ActiveDataProvider
     */
    public function search()
    {

        $query = $this->find();

        $query->modelClass = get_parent_class($this);

        $query->bySections($this->sectionsIds);

        $query->andFilterWhere($this->getAttributes());

        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ]);

        return $dataProvider;

    }


}

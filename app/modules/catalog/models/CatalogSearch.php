<?php

namespace app\modules\catalog\models;

use yii\data\ActiveDataProvider;
use Yii;
use yii\db\Expression;

/**
 * Class CatalogSearch
 * Модель для фильтрации элементов каталога
 * @package app\modules\catalog\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogSearch extends Catalog
{


    /**
     * Возвращает провайдер данных
     * @return ActiveDataProvider
     */
    public function publicSearch()
    {

        $query = $this->find();

        $query->modelClass = get_parent_class($this);

        if($this->validate()) {

            $query->bySections($this->sectionsIds);

            $query->andFilterWhere($this->getAttributes());

        } else {

            $query->where(new Expression("1!=1"));

        }

        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ]);

        return $dataProvider;

    }


}

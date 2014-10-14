<?php
namespace app\modules\shop;

use yii\base\InvalidConfigException;

/**
 * Class Shop
 * Модуль интернет магазина
 * @package app\modules\shop
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Shop extends \yii\base\Module
{
    /**
     * @var array массив классов моделей каталога продавемых через магазин
     */
    public $modelClasses = [];

    public $controllerNamespace = 'app\modules\shop\controllers';

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if(empty($this->modelClasses))
            throw new InvalidConfigException("Property modelClasses could not be empty");
    }

    /**
     * Возвращает массив имен моделей продаваемых через магазин
     * @return array
     */
    public function getModelNames()
    {

        $arr = [];

        foreach($this->modelClasses AS $class) {

            $arr[$class] = $class::getEntityName();

        }

        return $arr;

    }

}

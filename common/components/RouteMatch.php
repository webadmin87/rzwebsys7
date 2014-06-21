<?php
namespace common\components;

use Yii;


/**
 * Class RouteMatch
 * Совпадение с текущим маршрутом
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class RouteMatch extends Match {

    /**
     * Проверяет истинность php выражения
     * @param string $value строка с php кодом. Например return 1==1;
     * @return boolean
     */
    public function test($value)
    {

        return $value  == Yii::$app->requestedRoute;

    }


}

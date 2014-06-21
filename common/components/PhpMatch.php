<?php
namespace common\components;

use Yii;
use yii\base\Object;

/**
 * Class PhpMatch
 * Php выражение
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class PhpMatch extends Object implements IMatch {

    /**
     * Проверяет истинность php выражения
     * @param string $value строка с php кодом. Например return 1==1;
     * @return boolean
     */
    public function test($value)
    {

        return eval($value);

    }


}

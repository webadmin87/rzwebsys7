<?php
namespace common\components;

use Yii;

/**
 * Class PhpMatch
 * Php выражение
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PhpMatch extends Match
{

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

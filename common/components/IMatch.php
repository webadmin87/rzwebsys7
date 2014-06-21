<?php
namespace common\components;

/**
 * Interface IMatch
 * Интерфейс проверки условий
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */

interface IMatch {

    /**
     * @param mixed $value
     * @return boolean
     */
    public function test($value);

}
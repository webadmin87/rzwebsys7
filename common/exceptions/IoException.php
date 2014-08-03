<?php

namespace common\exceptions;

use yii\base\Exception;

/**
 * Class IoException
 * Исключение возникающее при ошибка ввода вывода файловой системы
 * @package common\exceptions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class IoException extends Exception
{

    /**
     * @inheritdoc
     */

    public function getName()
    {
        return "Io Exception";
    }

}
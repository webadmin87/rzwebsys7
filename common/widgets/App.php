<?php
namespace common\widgets;

use common\components\Match;
use yii\base\Widget;

/**
 * Class App
 * Базовый класс для виджетов приложения
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class App extends Widget
{

    /**
     * @var int тип условия для отображения виджета
     */

    public $showCondType = Match::COND_NO;

    /**
     * @var string условие отображения виджета
     */

    public $showCond;

    /**
     * @var string представление виджета
     */

    public $tpl = "index";

    /**
     * Отображать ли данный виджет
     * @return bool
     */

    public function isShow()
    {

        if (empty($this->showCondType))
            return true;
        else {

            $match = Match::getMatch($this->showCondType);

            if ($match)
                return $match->test($this->showCond);
            else
                return false;
        }

    }

}
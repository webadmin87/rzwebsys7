<?php

namespace common\behaviors;

use common\components\Match;
use yii\base\Behavior;

/**
 * Class MatchSuitable
 * Поведение для определения того, что выполняется заданное у модели условие
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class MatchSuitable extends Behavior {

    /**
     * @var string имя атрибута содержащего условие
     */
    public $condAttr = "cond";

    /**
     * @var string имя атрибута содержащего тип условия
     */
    public $condTypeAttr = "cond_type";

    /**
     * Выполняется ли условие
     * @return bool
     */
    public function isSuitable()
    {

        if (empty($this->owner->{$this->condAttr}))
            return true;
        else {

            $match = Match::getMatch($this->owner->{$this->condTypeAttr});

            if ($match)
                return $match->test($this->owner->{$this->condAttr});
            else
                return false;
        }

    }

} 
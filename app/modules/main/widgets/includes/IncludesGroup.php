<?php

namespace app\modules\main\widgets\includes;

use common\widgets\App;
use app\modules\main\models\IncludeGroup;

/**
 * Class IncludesGroup
 * Виджет для отображения групп включаемых областей
 * @package app\modules\main\widgets\includes
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class IncludesGroup extends App
{

    /**
     * @var string символьный код группы областей
     */

    public $code;

    /**
     * @var IncludeGroup группа областей
     */
    protected $group;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->isShow())
            return false;

        $this->locateGroup();

    }

    /**
     * Поиск подходящей включаемой области
     */
    protected function locateGroup()
    {

        $groups = IncludeGroup::find()->published()->andWhere(["code"=>$this->code])->orderBy(['sort'=>SORT_ASC])->all();

        foreach($groups AS $group) {

            if($group->isSuitable()) {

                $this->group = $group;

                break;

            }

        }

    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->isShow() OR empty($this->group))
            return false;

        $includes = $this->group->includes;

        $html = "";

        foreach($includes AS $include) {

            $html .= Includes::widget(["model"=>$include]);

        }

        return $html;

    }


} 
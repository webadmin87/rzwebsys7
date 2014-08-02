<?php
namespace common\controllers;

/**
 * Class Root
 * Базовый контроллер для разделов предназначенных только для суперпользователя
 * @package common\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Root extends Admin
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $parent = parent::behaviors();

        $parent['access']['rules'] = [[
            'allow' => true,
            'roles' => ['rootAccess'],
        ]];

        return $parent;
    }
}
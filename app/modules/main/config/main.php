<?php
return [

    'modules' => [

        'main' => [
            'class'=>app\modules\main\Main::className(),
            'controllerNamespace' => 'app\modules\main\controllers',
            'modules'=> ['admin'=>[
                'class'=>app\modules\main\modules\admin\Admin::className(),
                'controllerNamespace' => 'app\modules\main\modules\admin\controllers',
            ]],

        ],

    ],

];
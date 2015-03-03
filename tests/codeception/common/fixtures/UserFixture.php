<?php

namespace tests\codeception\common\fixtures;

use Yii;
use yii\test\ActiveFixture;

/**
 * User fixture
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\main\models\User';

    public function load()
    {
        parent::load();

        $installer = Yii::$app->rbacInstaller;

        $installer->assign();

    }


}

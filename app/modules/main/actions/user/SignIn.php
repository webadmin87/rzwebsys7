<?php
namespace app\modules\main\actions\user;

use app\modules\main\models\LoginForm;
use yii\base\Action;

/**
 * Class SignIn
 * Действие входа в систему
 * @package app\modules\main\actions\user
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SignIn extends Action
{

    /**
     * @var string url для редиректа после удачного логина
     */
    public $returnUrl;

    /**
     * @var string шаблон
     */
    public $tpl = "sign-in";

    /**
     * @inheritdoc
     */

    public function run()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $model = \Yii::createObject(LoginForm::className());

        if ($model->load(\Yii::$app->request->post()) && $model->login()) {

            if ($this->returnUrl)
                return $this->controller->redirect($this->returnUrl);
            else
                return $this->controller->goBack();

        } else {
            return $this->controller->render($this->tpl, [
                'model' => $model,
            ]);
        }

    }

}
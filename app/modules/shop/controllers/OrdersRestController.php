<?php
namespace app\modules\shop\controllers;

use app\modules\shop\models\Order;
use app\modules\shop\models\Status;
use common\db\ActiveRecord;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class OrdersRestController
 * Котроллер предоставляющий REST API для управления заказами
 * @package app\modules\shop\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class OrdersRestController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    /**
     * Отображает новые заказы
     * @return array|\yii\db\ActiveRecord[]
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionNew() {

        $searchModel = new Order();

        if (!Yii::$app->user->can('listModels', array("model" => $searchModel)))
            throw new ForbiddenHttpException('Forbidden');

        $searchModel->setScenario(ActiveRecord::SCENARIO_SEARCH);

        $perm = $searchModel->getPermission();

        $status = Status::findOne(["default"=>true]);

        if(!$status)
            throw new NotFoundHttpException;

        $query = Order::find()->published()->andWhere(["status_id"=>$status->id]);

        if ($perm)
            $perm->applyConstraint($query);

        return $query->all();

    }

}
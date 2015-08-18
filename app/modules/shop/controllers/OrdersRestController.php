<?php
namespace app\modules\shop\controllers;

use app\modules\shop\models\Order;
use app\modules\shop\models\Status;
use common\db\ActiveRecord;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

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

    /**
     * Список статусов заказа
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionStatuses() {

        return Status::find()->published()->all();

    }

    /**
     * Обновление заказа
     * @param int $id идентификатор заказа
     * @return null|static
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id) {

        $model = Order::findOne($id);

        if(!$model)
            throw new BadRequestHttpException('Bad request');

        $model->setScenario(ActiveRecord::SCENARIO_UPDATE);

        if (!Yii::$app->user->can('updateModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if (!Yii::$app->user->can('updateModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;

    }

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [

            'new'=>['get'],
            'statuses'=>['get'],
            'update'=>['put'],

        ];
    }


}
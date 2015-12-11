<?php

namespace app\modules\main\actions;

use Yii;
use yii\rest\Action;
use common\db\ActiveRecord;
use yii\web\ForbiddenHttpException;

/**
 * Class ReviewAdd
 * @package app\modules\main\actions
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewAdd extends Action
{

	/**
	 * @inheritdoc
	 * @return ActiveRecord
	 * @throws ForbiddenHttpException
	 * @throws \yii\base\InvalidConfigException
	 */
	public function run()
	{
		$class = $this->modelClass;

		/** @var ActiveRecord $model */
		$model = Yii::createObject(['class' => $class::className(), 'scenario' => ActiveRecord::SCENARIO_INSERT]);

		$model->load(Yii::$app->request->post());

		if (!Yii::$app->user->can('createModel', ['model' => $model])) {
			throw new ForbiddenHttpException();
		}

		if ($model->save()) {
			Yii::$app->response->setStatusCode(201);
		}

		return $model;
	}

}
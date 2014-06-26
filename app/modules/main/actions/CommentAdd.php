<?php
namespace app\modules\main\actions;

use Yii;
use yii\rest\Action;
use app\modules\main\models\Comments;
use common\db\ActiveRecord;
use common\db\TActiveRecord;
/**
 * Class CommentAdd
 * Добавление комментария
 * @package app\modules\main\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CommentAdd extends Action {



    /**
     * Добавление комментария
     * @return object
     * @throws \yii\base\InvalidConfigException
     */

    public function run() {

        $class = $this->modelClass;

        $request = Yii::$app->request;

        $response = Yii::$app->getResponse();

        $model = Yii::createObject(["class"=>$class::className(), 'scenario'=>ActiveRecord::SCENARIO_INSERT]);

        $model->load($request->post());

        if($parentId = $request->post("parent_id"))
            $parentModel = $class::findOne($parentId);
        else
            $parentModel = $class::findOne(TActiveRecord::ROOT_ID);

        if(!$parentModel)
            $response->setStatusCode(400);
        elseif($model->appendTo($parentModel))
            $response->setStatusCode(201);

        return $model;

    }


}
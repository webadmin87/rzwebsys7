<?php
namespace common\actions\crud;

use common\db\TActiveRecord;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class TAdmin
 * Класс действия для вывода списка древовидных моделей для администрирования
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TAdmin extends Admin
{

    public function run($parent_id = TActiveRecord::ROOT_ID)
    {

        $class = $this->modelClass;

        $searchModel = new $class;

        $parentModel = $class::find()->where(["id" => $parent_id])->one();

        if (!Yii::$app->user->can('listModels', array("model" => $searchModel)))
            throw new ForbiddenHttpException('Forbidden');

        $searchModel->setScenario($this->modelScenario);

        $query = $parentModel->children();

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $this->dataProviderConfig, $query);

        $perm = $searchModel->getPermission();

        if ($perm)
            $perm->applyConstraint($dataProvider->query);

        $dataProvider->getPagination()->pageSize = $this->pageSize;

        if ($this->orderBy)
            $dataProvider->getSort()->defaultOrder = $this->orderBy;

        $params = [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'parent_id' => $parent_id,
        ];

        if (!Yii::$app->request->isAjax)
            return $this->render($this->tpl, $params);
        else
            return $this->renderPartial($this->tpl, $params);

    }

}
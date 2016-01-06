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

    public $orderBy = ['lft'=>SORT_ASC];

    /**
     * @var string имя параметра передаваемого расширенным фильтром
     */
    public $extFilterParam = "extendedFilter";

    public function run($parent_id = TActiveRecord::ROOT_ID)
    {

        $class = $this->modelClass;

        $searchModel = new $class;

        if (!Yii::$app->user->can('listModels', array("model" => $searchModel)))
            throw new ForbiddenHttpException('Forbidden');

        $searchModel->setScenario($this->modelScenario);

        $requestParams = Yii::$app->request->getQueryParams();

        // Если поиск по расширенному фильтру, выводим одним списком

        if(isset($requestParams[$this->extFilterParam])) {
            $parentModel = $class::findOne(TActiveRecord::ROOT_ID);
            $query = $parentModel->children();
        }
        else {
            $parentModel = $class::findOne($parent_id);
            $query = $parentModel->children(1);
            $query->orderBy(null);
        }

        $dataProvider = $searchModel->search($requestParams, $this->dataProviderConfig, $query);

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
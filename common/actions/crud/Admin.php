<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class Admin
 * Класс действия для вывода списка моделей для администрирования
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Admin extends Base {

    /**
     * @var string сценарий для валидации
     */

    public $modelScenario = 'search';

    /**
     * @var array настройки провайдера данных
     */
    public $dataProviderConfig = [];

    /**
     * @var string путь к шаблону для отображения
     */

    public $tpl = "index";

    /**
     * @var int количество элементов на странице
     */

    public $pageSize = 20;

    /**
     * @var array сортировка
     */

    public $orderBy;

    /**
     * Запуск действия вывода списка моделей
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     */

    public function run() {


        $searchModel = new $this->modelClass;

        if(!Yii::$app->user->can('listModel', array("model"=>$searchModel)))
            throw new ForbiddenHttpException('Forbidden');

        $searchModel->setScenario($this->modelScenario);

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $this->dataProviderConfig);

        $dataProvider->getPagination()->pageSize = $this->pageSize;

        if($this->orderBy)
            $dataProvider->getSort()->defaultOrder = $this->orderBy;

        $params = [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ];

        if(!Yii::$app->request->isAjax)
            return $this->render($this->tpl, $params);
        else
            return $this->renderPartial($this->tpl, $params);


    }

}
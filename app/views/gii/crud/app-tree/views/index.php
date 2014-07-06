<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>
use yii\helpers\Html;
use common\widgets\admin\CrudLinks;
use yii\widgets\Breadcrumbs;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var <?=$generator->modelClass?> $searchModel
* @var int $parent_id
*/

$this->title = \Yii::t($this->context->tFile, <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>);
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="user-index">

    <h1><?echo '<?='?> Html::encode($this->title) ?></h1>

    <?echo '<?='?>$this->render('_filter', ['model' => $searchModel]); ?>

    <hr />

    <p>
        <?echo '<?='?>CrudLinks::widget(["action"=>CrudLinks::CRUD_LIST, "model"=>$searchModel, "urlParams"=>["parent_id"=>$parent_id]])?>
    </p>

    <?echo '<?='?> Breadcrumbs::widget([
        'homeLink'=>[
            "label"=>\Yii::t($this->context->tFile, 'Root'),
            "url"=>["/".Yii::$app->controller->route]
        ],
        'links' => $searchModel->getBreadCrumbsItems($parent_id, function($model) { return ["/".Yii::$app->controller->route, "parent_id"=>$model->id]; }),
    ]) ?>

    <?echo '<?='?>$this->render('_grid', ['dataProvider' => $dataProvider, "searchModel"=>$searchModel]); ?>


</div>

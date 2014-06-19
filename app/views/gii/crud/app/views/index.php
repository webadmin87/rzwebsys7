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
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var <?=$generator->modelClass?> $searchModel
*/

$this->title = \Yii::t($this->context->tFile, <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>);
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="user-index">

    <h1><?echo '<?='?> Html::encode($this->title) ?></h1>

    <?echo '<?='?>$this->render('_filter', ['model' => $searchModel]); ?>

    <hr />

    <p>
        <?echo '<?='?>CrudLinks::widget(["action"=>CrudLinks::CRUD_LIST, "model"=>$searchModel])?>
    </p>

    <?echo '<?='?>$this->render('_grid', ['dataProvider' => $dataProvider, "searchModel"=>$searchModel]); ?>


</div>

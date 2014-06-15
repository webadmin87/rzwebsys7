<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/**
 * This is the template for generating a CRUD controller class file.
 *
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}
echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\filters\VerbFilter;
use common\actions\crud;
use common\controllers\Admin;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

    /**
    * @var string идентификатор файла перевода
    */

    public $tFile = "moduleCode/app";

    /**
    * Поведения
    * @return array
    */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'groupdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
    * Действия
    * @return array
    */
    public function actions() {

        $class = <?= $modelClass ?>::className();

        return [

            'index'=>[
                'class'=>crud\TAdmin::className(),
                'modelClass'=>$class,
            ],
            'create'=>[
                'class'=>crud\TCreate::className(),
                'modelClass'=>$class,
            ],
            'update'=>[
                'class'=>crud\TUpdate::className(),
                'modelClass'=>$class,
            ],

            'view'=>[
                'class'=>crud\View::className(),
                'modelClass'=>$class,
            ],

            'delete'=>[
                'class'=>crud\TDelete::className(),
                'modelClass'=>$class,
            ],

            'groupdelete'=>[
                'class'=>crud\TGroupDelete::className(),
                'modelClass'=>$class,
            ],

            'up'=>[
                'class'=>crud\TUp::className(),
                'modelClass'=>$class,
            ],

            'down'=>[
                'class'=>crud\TDown::className(),
                'modelClass'=>$class,
            ],

            'replace'=>[
                'class'=>crud\TReplace::className(),
                'modelClass'=>$class,
            ],

        ];

    }

}
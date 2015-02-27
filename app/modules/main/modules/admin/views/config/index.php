<?php

use common\widgets\admin\CrudLinks;
use common\widgets\admin\TableInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var \app\modules\main\models\Config[] $models массив моделей конфигурации
 * @var app\modules\main\models\Config $searchModel
 */

?>
    <h1><?= Yii::t('main/app', 'Config') ?></h1>

    <div class="alert alert-danger">

        <?=Yii::t('main/app', 'Attention! Any not careful changes in this section may break your site!')?>

    </div>

    <p>
        <?= CrudLinks::widget(["action" => CrudLinks::CRUD_LIST, "model" => $searchModel]) ?>
    </p>

<?php

$form = ActiveForm::begin();

echo TableInput::widget(
    [
        'form' => $form,
        "models" => $models,
        "tableOptions" => ["class" => "table table-striped table-action"],
        "rowLinks" => [

            [
                "label"=>Yii::t('main/app', 'Delete'),
                "url"=>function($index, $model){
                    return \yii\helpers\Url::toRoute(['/main/admin/config/delete', 'id'=>$model->id]);
                },
                "options"=>[
                    'class'=>'btn btn-danger btn-xs',
                    'data-method'=>'post',
                    'data-confirm'=>Yii::t('yii', 'Are you sure you want to delete this item?')
                ],
            ]

        ],
    ]);

echo Html::submitButton(Yii::t('main/app', 'Save'), ['class' => 'btn btn-primary']);

ActiveForm::end();
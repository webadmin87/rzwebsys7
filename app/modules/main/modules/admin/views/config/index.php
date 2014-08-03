<?php

use common\widgets\admin\TableInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\modules\main\models\Config[] $models массив моделей конфигурации
 */

?>
    <h1><?= Yii::t('main/app', 'Config') ?></h1>
<?php

$form = ActiveForm::begin();

echo TableInput::widget(['form' => $form, "models" => $models, "tableOptions" => ["class" => "table table-striped"]]);

echo Html::submitButton(Yii::t('main/app', 'Submit'), ['class' => 'btn btn-primary']);

ActiveForm::end();
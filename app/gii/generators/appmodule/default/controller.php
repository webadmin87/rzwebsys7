<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator \app\gii\generators\appmodule\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use common\controllers\App;

class DefaultController extends App
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}

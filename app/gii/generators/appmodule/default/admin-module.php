<?php
/**
 * This is the template for generating a admin module class file.
 */

/* @var $this yii\web\View */
/* @var $generator \app\gii\generators\appmodule\Generator */

$ns = $generator->adminModuleNs;
$className = $generator->getClassName($generator->adminModuleClass);


echo "<?php\n";
?>

namespace <?= $ns ?>;

use common\core\AdminModule;

class <?= $className ?> extends AdminModule
{

}

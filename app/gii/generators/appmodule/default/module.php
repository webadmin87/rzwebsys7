<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator \app\gii\generators\appmodule\Generator */

$ns = $generator->moduleNs;
$className = $generator->getClassName($generator->moduleClass);

echo "<?php\n";
?>

namespace <?= $ns ?>;

class <?= $className ?> extends \yii\base\Module
{
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

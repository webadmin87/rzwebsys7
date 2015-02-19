<?php
namespace app\modules\main\widgets\includes;

use app\modules\main\models\Includes as Model;
use common\widgets\App;
use Yii;

/**
 * Class Includes
 * Виджет для вывода включаемых областей
 * @package app\modules\main\widgets\includes
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Includes extends App
{

    /**
     * @var string символьный код включаемой области
     */

    public $code;

    /**
     * @var \app\modules\main\models\Includes $model модель включаемой области
     */

    public  $model;

    public function init()
    {

        if (!$this->isShow())
            return false;

        if($this->model === null)
            $this->model = Model::findByCode($this->code);

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        if (!$this->isShow() OR empty($this->model))
            return false;

        if (!empty($this->model->file))
            return $this->view->renderFile($this->model->file);
        else
            return $this->model->text;

    }

}
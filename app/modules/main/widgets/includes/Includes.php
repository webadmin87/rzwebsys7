<?php
namespace app\modules\main\widgets\includes;

use Yii;
use common\widgets\App;
use app\modules\main\models\Includes AS Model;
/**
 * Class Includes
 * Виджет для вывода включаемых областей
 * @package app\modules\main\widgets\includes
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Includes extends App {

    /**
     * @var string символьный код включаемой области
     */

    public $code;

    /**
     * @var \app\modules\main\models\Includes $model модель включаемой области
     */

    protected $model;

    public function init() {

        if(!$this->isShow())
            return false;

        $this->model = Model::findByCode($this->code);

    }


    /**
     * @inheritdoc
     */

    public function run() {

        if(!$this->isShow() OR empty($this->model))
            return false;

        if(!empty($this->model->file))
            return $this->view->renderFile($this->model->file);
        else
            return $this->model->text;

    }

}
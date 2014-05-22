<?php
namespace common\db\fields;

use Yii;
use Yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\widgets\html5uploader\Widget AS Html5Widget;


/**
 * Class Html5FileField
 * Поле загрузки файлов средствами html5
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Html5FileField extends TextField {

    /**
     * @inheritdoc
     */

    public $showInExtendedFilter = false;

    /**
     * @var string маршруд для загрузки файлов
     */

    public $route = "admin/upload";

    /**
     * Преффикс поведений
     */

    const BEHAVIOR_PREF = "file";

    /**
     * @inheritdoc
     */

    public function behaviors() {

        $beh = parent::behaviors();

        $code = self::BEHAVIOR_PREF.ucfirst($this->attr);

        return array_merge($beh, [

            $code => [

                "class" => \common\behaviors\Html5UploadBehavior::className(),
                "attribute"=> $this->attr,

            ],

        ]);

    }

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = []) {

        return Html5Widget::widget([
            "model"=>$this->model,
            "attribute"=>$this->attr,
            "maxFileSize"=>$this->model->getMaxFileSize(),
            "options"=>$options,
            "uploadUrl"=>Yii::$app->urlManager->createUrl([$this->route, "model"=>get_class($this->model), "attr"=>$this->attr]),
        ]);

    }


    /**
     * @inheritdoc
     */
    public function grid() {

        $grid = parent::grid();

        $grid['format'] = 'html';

        $grid['value']=function($model, $index, $widget) {

            if(is_array($model->{$this->attr})) {

                return $this->renderFilesView($model->{$this->attr});

            } else {

                return null;

            }


        };

        return $grid;

    }

    /**
     * @inheritdoc
     */
    public function view() {

        $view = parent::view();

        $view["value"] = $this->renderFilesView($this->model->{$this->attr});

        $view["format"] = "html";

        return $view;

    }

    /**
     * Возвращает строку для отображения файлов в гриде
     * @param $files
     * @return string
     */

    protected function renderFilesView($files) {

        $html = "";

        foreach($files AS $file)
            $html .= '<a href="'.$file["file"].'"><span class="glyphicon glyphicon-download"></span></a>'."\n";

        return $html;

    }


    /**
     * @inheritdoc
     */

    protected function defaultGridFilter() {

        return false;

    }


}
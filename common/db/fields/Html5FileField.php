<?php
namespace common\db\fields;

use Yii;

/**
 * Class Html5FileField
 * Поле загрузки файлов средствами html5
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Html5FileField extends Field
{

    /**
     * Преффикс поведений
     */
    const BEHAVIOR_PREF = "file";

    /**
     * @inheritdoc
     */
    public $showInExtendedFilter = false;


    /**
     * @var string алиас DOCUMENT ROOT
     */
    public $webroot = "@webroot";

    /**
     * @inheritdoc
     */
	public $inputClass = "\\common\\inputs\\Html5FileInput";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $beh = parent::behaviors();

        $code = self::BEHAVIOR_PREF . ucfirst($this->attr);

        return array_merge($beh, [

            $code => [

                "class" => \common\behaviors\Html5UploadBehavior::className(),
                "attribute" => $this->attr,

            ],

        ]);

    }

    /**
     * @inheritdoc
     */
    protected function grid()
    {

        $grid = parent::grid();

        $grid['format'] = 'html';

        $grid['value'] = function ($model, $index, $widget) {

            if (is_array($model->{$this->attr})) {

                return $this->renderFilesGridView($model->{$this->attr});

            } else {

                return null;

            }

        };

        return $grid;

    }

    /**
     * Возвращает строку для отображения файлов в гриде
     * @param array $files массив с описанием файлов
     * @return string
     */

    protected function renderFilesGridView($files)
    {

        return $this->renderFilesView($files);

    }

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = parent::view();

		if (is_array($this->model->{$this->attr})) {

			$view["value"] = $this->renderFilesView($this->model->{$this->attr});

			$view["format"] = "html";

		}

        return $view;

    }

    /**
     * Возвращает строку для отображения файлов при детальном просмотре
     * @param array $files массив с описанием файлов
     * @return string
     */

    protected function renderFilesView($files)
    {

        $html = "";

        foreach ($files AS $file)
            $html .= '<a href="' . $file["file"] . '"><span class="glyphicon glyphicon-download"></span></a>' . "\n";

        return $html;

    }

    /**
     * @inheritdoc
     */

    protected function defaultGridFilter()
    {

        return false;

    }

}
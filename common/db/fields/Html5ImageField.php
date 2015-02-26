<?php
namespace common\db\fields;

use common\helpers\FileHelper;
use Yii;
use yii\helpers\Html;

/**
 * Class Html5ImageField
 * Поле загрузки изображений средствами html5
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Html5ImageField extends Html5FileField
{

    /**
     * Размер по умолчанию для превью изображений в гриде и при детальном просмотре
     */
    const DEFAULT_SIZE = 120;

    /**
     * @var int ширина изображения при детальном просмотре
     */
    public $viewWidth = self::DEFAULT_SIZE;

    /**
     * @var int высота изображения при детальном просмотре
     */
    public $viewHeight = self::DEFAULT_SIZE;

    /**
     * @var int ширина изображения в гриде
     */
    public $gridWidth = self::DEFAULT_SIZE;

    /**
     * @var int высота изображения в гриде
     */
    public $gridHeight = self::DEFAULT_SIZE;

	/**
	 * @inheritdoc
	 */
	public $widgetOptions = [
        "allowedExt" => ["jpg", "jpeg", "gif", "png"]
    ];

    /**
     * @var array html атрибуты превью изображений
     */
    public $imageOptions = [];

    /**
     * @inheritdoc
     */
    protected function renderFilesView($files)
    {

        $html = "";

        foreach ($files AS $file) {

            $path = Yii::getAlias($this->webroot) . $file["file"];

            $html .= $this->renderImageTag($path, $this->viewWidth, $this->viewHeight);

        }

        return $html;

    }

    /**
     * Возвращает html тег изображения. Производит ресайз
     * @param string $path путь к файлу
     * @param int $width ширина изображения
     * @param int $height высота изображения
     * @return string
     */
    protected function renderImageTag($path, $width, $height)
    {

        if (!is_file($path) OR !FileHelper::isImage($path))
            return "";

        $options = array_merge([
            "src" => Yii::$app->resizer->resize($path, $width, $height),
            "class" => "img-thumbnail detail-img",
        ], $this->imageOptions);

        return Html::tag('img', '', $options);

    }

    /**
     * @inheritdoc
     */
    protected function renderFilesGridView($files)
    {

        if ($file = current($files)) {

            $path = Yii::getAlias($this->webroot) . $file["file"];

            return $this->renderImageTag($path, $this->gridWidth, $this->gridHeight);

        }

        return "";

    }

}
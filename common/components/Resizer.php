<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\imagine\Image;
use Imagine\Image\Box;
use common\helpers\FileHelper;

/**
 * Class Resizer
 * Компонент для ресайза изображений. Использует библиотеку расширение imagine
 * @link https://github.com/yiisoft/yii2/tree/master/extensions/imagine
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Resizer extends Component {

    /**
     * @var string алиас папки для сохранения изображений
     */

    public $thumbs = "@thumbs";

    /**
     * @var string алиас для DOCUMENT ROOT
     */

    public  $webroot = "@webroot";

    /**
     * Уменьшение размеров изображения. Возвращает путь к изображению относительно DOCUMENT ROOT.
     * Если ширина или высота равняются нулю, уменьшение происходит пропорционально заданному размеру.
     * Если и ширина и высота равняются нулю, уменьшения не происходит
     * @param string $path путь к изображению
     * @param int $width ширина
     * @param int $height высота
     * @return string
     */

    public function resize($path, $width = 0, $height = 0) {

        $savePath = $this->getSavePath($this->getThumbName($path, $width, $height));

        if(is_file($savePath)) {

            return $this->getRelPath($savePath);

        }

        $image = Image::getImagine()->open($path);

        $box = $this->getSize($image, $width, $height);

        $image->resize($box);

        $image->save($savePath);

        return $this->getRelPath($savePath);

    }

    /**
     * Уменьшает изображение если его размер превашает заданные значения
     * @param $savePath путь до изображения
     * @param int $width максимальная ширина
     * @param int $height максимальная высота
     * @return bool
     */

    public function resizeIfGreater($savePath, $width, $height) {

        $image = Image::getImagine()->open($savePath);

        if(!$image) return false;

        $size = $image->getSize();

        $resize = false;

        if( $size->getWidth() > $width ) {

            $box = $this->getSize($image, $width, 0);

            $image->resize($box);

            $size = $image->getSize();

            $resize = true;

        }

        if( $size->getHeight() > $height ) {

            $box = $this->getSize($image, 0, $height);

            $image->resize($box);

            $resize = true;

        }

        if($resize)
            $image->save($savePath);

        return $resize;

    }

    /**
     * Возвращает размеры конечного зображения
     * @param \Imagine\Image\ImageInterface $image изображение
     * @param int $width требуемая ширина
     * @param int $height требуемая высота
     * @return \Imagine\Image\Box
     */

    public function getSize($image, $width, $height) {

        $size = $image->getSize();

        if($width == 0 AND $height == 0) {

            $arr = [$size->getWidth(), $size->getHeight()];

        } elseif($width == 0) {

            $newWidth = ($size->getWidth()*$height)/$size->getHeight();

            $arr = [$newWidth, $height];

        } elseif($height == 0) {

            $newHeight = ($width*$size->getHeight())/$size->getWidth();

            $arr = [$width, $newHeight];

        } else {

            $arr = [$width, $height];

        }

        $box = new Box($arr[0], $arr[1]);

        return $box;

    }

    /**
     * Возвращает имя изображени для охранения
     * @param string $path путь к изображению
     * @param int $width ширина
     * @param int $height высота
     * @return string
     */

    public function getThumbName($path, $width, $height) {

        $md5 = md5($path . filectime($path) . $width . $height);

        $ext = FileHelper::getExtension($path);

        return $md5 . "." . $ext;

    }

    /**
     * Возвращает путь для сохранения изображения
     * @param string $name имя файла
     * @return string
     */

    public function getSavePath($name) {

        return Yii::getAlias($this->thumbs) . DIRECTORY_SEPARATOR . $name;

    }

    /**
     * Возвращает путь к изображению относительно DOCUMENT ROOT
     * @param string $path путь к файлу
     * @return string
     */

    public function getRelPath($path)
    {

        return str_replace(Yii::getAlias($this->webroot), '', $path);

    }



}
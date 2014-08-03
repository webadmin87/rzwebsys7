<?php

namespace common\core;

use common\exceptions\IoException;
use common\helpers\FileHelper;
use Yii;
use yii\base\Object;

/**
 * Class File
 * Класс файла
 * @package common\core
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class File extends Object
{

    /**
     * @var string пояснение к файлу
     */

    public $title;

    /**
     * @var string алиас для DOCUMENT ROOT
     */

    public $webroot = "@webroot";

    /**
     * @var string абсолютный путь к файлу
     */

    protected $path;

    /**
     * Конструктор
     * @param string $path
     * @param array $config
     * @throws \common\exceptions\IoException
     */

    public function __construct($path, $config = [])
    {

        if (!is_file($path))
            throw new IoException(Yii::t('core', 'File {file} does not exists.', ["{file}" => $path]));

        $this->path = $path;

        parent::__construct($config);

    }

    /**
     * Возвращает путь к файлу
     * @return string
     */

    public function getPath()
    {

        return $this->path;

    }

    /**
     * Возвращает путь к файлу относительно DOCUMENT ROOT
     * @return string
     */

    public function getRelPath()
    {

        return str_replace(Yii::getAlias($this->webroot), '', $this->path);

    }

    /**
     * Возвращает размер файла в человекопонятном виде
     * @return string
     */

    public function getHumanSize()
    {

        $size = $this->getSize();

        if ($size < 1024)
            return $size . "b";
        elseif ($size < 1024 * 1024)
            return round($size / 1024) . "Kb";
        elseif ($size < 1024 * 1024 * 1024)
            return round($size / 1024 / 1024, 1) . "Mb";
        else
            return round($size / 1024 / 1024 / 1024, 1) . "Gb";

    }

    /**
     * Возвращает размер файла в байтах
     * @return int
     */

    public function getSize()
    {

        return filesize($this->path);

    }

    /**
     * Возвращает mime тип файла
     * @return string
     */

    public function getMimeType()
    {

        return FileHelper::getMimeType($this->path);

    }

    /**
     * Возвращает имя файла
     * @return string
     */

    public function getName()
    {

        return basename($this->path);

    }

    /**
     * Возвращает расширение файла
     * @return string
     */

    public function getExt()
    {

        return FileHelper::getExtension($this->path);

    }

    /**
     * Удаление файла
     * @return bool
     */

    public function delete()
    {

        return unlink($this->path);

    }

    /**
     * Копирование файла
     * @param string $dest путь для копирования
     * @return bool|\common\core\File
     */

    public function copyTo($dest)
    {

        if (copy($this->path, $dest)) {

            $class = get_class($this);

            return new $class($dest);

        } else {

            return false;

        }

    }

    /**
     * Является ли файл изображением
     * @return bool
     */

    public function isImage()
    {

        return FileHelper::isImage($this->path);

    }

}
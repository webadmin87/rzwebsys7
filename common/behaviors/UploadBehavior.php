<?php

namespace common\behaviors;

use common\core\File;
use common\helpers\FileHelper;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class UploadBehavior
 * Поведение загрузки файлов
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
abstract class UploadBehavior extends Behavior
{

    /**
     * @var array расширения разрешенные для загрузки
     */

    public $allowed = ["jpg", "jpeg", "gif", "png", "pdf", "doc", "docx", "xsl", "xslx", "odt", "ppt", "zip", "rar", "gz", "tar", "swf", "csv"];

    /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attribute = 'image';

    /**
     * @var string алиас папки для сохранения картинок
     */

    public $folder = "@userfiles";

    /**
     * @var string алиас DOCUMENT ROOT
     */

    public $webroot = "@webroot";

    /**
     * @var int права доступа на создаваемые папки
     */

    public $folderPerm = 0755;

    /**
     * @var int права доступа на создаваемые файлы
     */

    public $filePerm = 0644;

    /**
     * @var int максимальная ширина загружаемого изображения
     */

    public $maxWidth = 1000;

    /**
     * @var int максимальная высота загружаемого изображения
     */

    public $maxHeight = 1000;

    /**
     * @var int максимальный размер файла в мегабайтах
     */

    protected $maxFileSize = 50;

    /**
     * @var array предыдущее значение атрибута модели хранящего информацию о прицепленных файлах. Устанавливается в afterFind.
     */

    protected $_value = array();

    /**
     * @inheritdoc
     */

    public function  events()
    {

        return [

            ActiveRecord::EVENT_BEFORE_VALIDATE => "beforeValidate",
            ActiveRecord::EVENT_BEFORE_INSERT => "beforeSave",
            ActiveRecord::EVENT_BEFORE_UPDATE => "beforeSave",
            ActiveRecord::EVENT_AFTER_INSERT => "afterSave",
            ActiveRecord::EVENT_AFTER_UPDATE => "afterSave",
            ActiveRecord::EVENT_AFTER_FIND => "afterFind",
            ActiveRecord::EVENT_BEFORE_DELETE => "beforeDelete",

        ];

    }

    /**
     * Загрузка файлов по имени. Возвращает массив путей к загруженным файлам, относительно DOCUMENT_ROOT.
     * @param $name имя файла
     * @return array
     */

    public function uploadFiles($name)
    {

        $this->checkModelFolder();

        // Множественная загрузка файлов

        $files = UploadedFile::getInstancesByName($name);

        // Единичная загрузка. Удаляем старые файлы

        if (empty($files) AND $file = UploadedFile::getInstanceByName($name)) {

            $this->deleteFiles();

            $files = array($file);

        }

        $fileNames = [];

        if (!empty($files)) {

            foreach ($files As $file) {

                $fileName = FileHelper::getNameForSave($this->getSavePath(), $file->name);

                $fileNames[] = $this->getRelPath() . $fileName;

                $savePath = $this->getSavePath() . $fileName;

                $file->saveAs($savePath);

                chmod($savePath, $this->filePerm);

                if (FileHelper::isImage($savePath)) {

                    Yii::$app->resizer->resizeIfGreater($savePath, $this->maxWidth, $this->maxHeight);

                }

            }

        }

        return $fileNames;

    }

    /**
     * Проверяет существование папки для сохранения файлов модели. Если ее нет, то создает
     */

    protected function checkModelFolder()
    {

        $path = $this->getSavePath();

        if (is_dir($path)) return;

        mkdir($path, $this->folderPerm);

    }

    /**
     * Возвращает путь к директории,
     * в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getSavePath()
    {

        return Yii::getAlias($this->folder) . DIRECTORY_SEPARATOR . $this->getModelFolderName() . DIRECTORY_SEPARATOR;
    }

    /**
     * Возвращает имя папки для сохранения файлов модели
     * @return string
     */

    public function getModelFolderName()
    {

        $class = get_class($this->owner);

        $class = trim($class, "\\");

        $class = str_replace("\\", "_", $class);

        return strtolower($class);

    }

    /**
     * Удаляет файлы перед сохранением
     * @return bool
     */

    protected function deleteFiles()
    {

        if (!is_array($this->_value))
            return false;

        foreach ($this->_value AS $v) {

            $path = Yii::getAlias($this->webroot) . $v["file"];

            if (!$this->hasFile($v["file"]) AND is_file($path))
                unlink($path);

        }

        return true;

    }

    /**
     * Есть ли файл у модели
     * @param $fileName путь к файлу относительно DOCUMENT ROOT
     * @return bool
     */

    public function hasFile($fileName)
    {

        $attr = $this->attribute;

        if (is_array($this->owner->$attr)) {

            foreach ($this->owner->$attr AS $v) {

                if ($v["file"] == $fileName)
                    return true;

            }

        }

        return false;

    }

    /**
     * Возвращает путь к изображению для публикации на страничке
     * @return type
     */

    public function getRelPath()
    {

        return str_replace(Yii::getAlias($this->webroot), '', $this->getSavePath());
    }

    /**
     * Возвращает массив описывающий загруженные файлы
     * @param $files массив путей загруженных файлов относительно корня
     * @return array
     */

    public function getFilesArr($files)
    {

        $arr = [];

        foreach ($files AS $file) {

            $arr[] = [

                "file" => $file,
                "title" => basename($file),

            ];

        }

        return $arr;

    }

    /**
     * Выполняется перед валидацией модели
     * @return bool|void
     */

    public function beforeValidate()
    {

        // Валидируем размер файлов

        $files = UploadedFile::getInstances($this->owner, $this->attribute);

        $maxSize = (double)$this->getMaxFileSize(); // Максимальный размер файла

        foreach ($files As $file) {

            $fileSize = (double)($file->size / 1024) / 1024; // Размер файла в мегабайтах

            if ($fileSize > $maxSize)
                $this->owner->addError($this->attribute,
                    Yii::t('core', 'Size of file {file} is more than {size} Mb', ['{file}' => $file->name, '{size}' => $maxSize]));

            if (!$this->isAllowedToUpload($file))
                $this->owner->addError($this->attribute,
                    Yii::t('core', 'File {file} is not allowed to upload', ['{file}' => $file->name]));

        }

        return true;

    }

    /**
     * Возвращает максимальный размер загружаемого файла в мегабайтах. Значение ограничено настройками php.
     * @return int
     */

    public function getMaxFileSize()
    {

        $phpMaxFileSize = (int)ini_get("upload_max_filesize");

        $maxFileSize = ($this->maxFileSize <= $phpMaxFileSize) ? $this->maxFileSize : $phpMaxFileSize;

        return $maxFileSize;

    }

    /**
     * Устанавливает максимальный размер загружаемого файла
     * @param int $val размер файла в мегабайтах
     */

    public function setMaxFileSize($val)
    {

        $this->maxFileSize = $val;

    }

    /**
     * Разрешен ли файл к загрузке
     * @param $file UploadedFile
     * @return bool
     */

    protected function isAllowedToUpload($file)
    {

        $ext = FileHelper::getExtension($file->name);

        return in_array($ext, $this->allowed);

    }

    /**
     * Возвращает первый файл
     * @param string $attr атрибут
     * @return File|bool
     */

    public function getFirstFile($attr = null)
    {
        if (empty($attr)) {
            $attr = $this->attribute;
        }

        $files = $this->owner->$attr;

        if (!is_array($files) OR empty($files))
            return false;

        $file = current($files);

        if (!is_file(Yii::getAlias($this->webroot) . $file["file"]))
            return false;

        $path = Yii::getAlias($this->webroot) . $file["file"];

        return Yii::createObject([

            "class" => File::className(),
            "title" => $file['title'],

        ], [$path]);

    }

    /**
     * Возвращает массив имен файлов
     * @param string $attr атрибут
     * @return array
     */

    public function getFiles($attr = null)
    {

        if (empty($attr))
            $attr = $this->attribute;

        $arr = [];

        if (!is_array($this->owner->$attr))
            return $arr;

        foreach ($this->owner->$attr AS $file) {

            $path = Yii::getAlias($this->webroot) . $file["file"];

            if (is_file($path)) {
                $arr[] = Yii::createObject([
                    "class" => File::className(),
                    "title" => $file['title'],
                ], [$path]);
            }

        }
        return $arr;

    }

    /**
     * Возвращает количество файлов
     * @param string $attr атрибут
     * @return integer
     */

    public function countFiles($attr = null)
    {

        if (empty($attr)) {
            $attr = $this->attribute;
        }

        if (empty($this->owner->$attr)) {
            return 0;
        }

        return count($this->owner->$attr);

    }

    /**
     * Удаление файла
     * @param $fileName путь к файлу относительно DOCUMENT ROOT
     * @param string $attr атрибут
     * @return bool
     */

    public function removeFile($fileName, $attr = null)
    {

        if (empty($attr)) {
            $attr = $this->attribute;
        }

        if (!is_array($this->owner->$attr))
            return false;

        $arr = $this->owner->$attr;

        foreach ($arr AS $k => $file) {

            if ($file['file'] == $fileName) {

                unset($arr[$k]);

                $this->owner->$attr = $arr;

                $filePath = Yii::getAlias($this->webroot) . $fileName;

                if (is_file($filePath))
                    unlink($filePath);

                return true;

            }

        }

        return false;

    }

    /**
     * После сохранения модели
     * @return bool
     */

    public function afterSave()
    {

        $attr = $this->attribute;

        if (!empty($this->owner->$attr))
            $this->owner->$attr = unserialize($this->owner->$attr);

        return true;
    }

    /**
     * После выборки модели
     * @return bool
     */

    public function afterFind()
    {

        $attr = $this->attribute;

        if (!empty($this->owner->$attr)) {

            $arr = unserialize($this->owner->$attr);
            $this->owner->$attr = $arr;
            $this->_value = $arr;

        }
        return true;
    }

    /**
     * Перед удалением модели
     * @return bool
     */

    public function beforeDelete()
    {
        $this->deleteAllFiles(); // удалили модель, удаляем и файл от неё
        return true;
    }

    /**
     * Удаление файлов связанных с моделью
     * @param string $attr атрибут
     * @return bool
     */

    public function deleteAllFiles($attr = null)
    {

        if (empty($attr)) {
            $attr = $this->attribute;
        }

        $files = $this->owner->$attr;

        if (!is_array($files))
            return false;

        foreach ($files AS $file) {

            $filePath = Yii::getAlias($this->webroot) . $file["file"];

            if (is_file($filePath))
                unlink($filePath);
        }

        $this->owner->$attr = null;

        return true;

    }

    /**
     * Обработка загрузки файлов должна быть здесь
     */

    abstract function beforeSave();

}
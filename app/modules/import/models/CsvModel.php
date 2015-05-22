<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 13.05.15
 * Time: 10:14
 */

namespace app\modules\import\models;

use Yii;
use yii\base\Model;

/**
 * Class CsvModel
 * Модель CSV файла
 * @package app\modules\import\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CsvModel extends Model
{

    const SCENARIO_COMPLETE = "complete";

    /**
     * @var string класс модели
     */
    public $modelClass;

    /**
     * @var string путь к файлу
     */
    public $filePath;

    /**
     * @var string папка относительно которой задается путь к файлу
     */
    public $filesDir = "@webapp/web";

    /**
     * @var bool первая строка файла содержит названия полей
     */
    public $headLine = false;

    /**
     * @var string ключ для связи моделей
     */
    public $key = 'id';

    /**
     * @var string разделитель полей в файле
     */
    public $delimiter = ',';

    /**
     * @var string символ в который заключено содержимое полей файла
     */
    public $enclosure = '"';

    /**
     * @var string символ экранирования
     */
    public $escape = '"';

    /**
     * @var array сопоставление атрибутов модели и полей файла
     */
    public $mapping = [];

    /**
     * @var bool производить валидацию моделей при сохранении
     */
    public $validate = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelClass', 'filePath', 'key', 'delimiter', 'enclosure', 'escape'], 'required'],
            [['headLine', 'validate', 'mapping'], 'safe'],
            [['mapping'], 'required', 'on'=>self::SCENARIO_COMPLETE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            "modelClass"=>\Yii::t('import/app', 'Model class'),
            "filePath"=>\Yii::t('import/app', 'File path'),
            "headLine"=>\Yii::t('import/app', 'Head line'),
            "key"=>\Yii::t('import/app', 'Key'),
            "delimiter"=>\Yii::t('import/app', 'Delimiter'),
            "enclosure"=>\Yii::t('import/app', 'Enclosure'),
            "escape"=>\Yii::t('import/app', 'Escape'),
            "mapping"=>\Yii::t('import/app', 'Attributes to columns mapping'),
            "validate"=>\Yii::t('import/app', 'Validate model'),

        ];
    }

    /**
     * Открывает файл
     * @return bool|resource
     */
    public function openFile()
    {

        $path = Yii::getAlias($this->filesDir . $this->filePath);

        if(!is_file($path))
            return false;

        return fopen($path, "r");

    }

    /**
     * Закрывает файл
     * @param resource $handle
     */
    public function closeFile($handle)
    {
        fclose($handle);
    }

    /**
     * Читает строку из файла
     * @param resource $handle
     * @return array
     */
    public function readLine($handle)
    {
        return fgetcsv($handle, 0, $this->delimiter, $this->enclosure, $this->escape);
    }

    /**
     * Читает первую строку из файла
     * @return array|bool
     */
    public function readFirstLine()
    {

        $handle = $this->openFile();

        if($handle !== false) {

            $data = $this->readLine($handle);

            $this->closeFile($handle);

            return $data;

        }

        return false;

    }

    /**
     * Возвращает массив колонок файла
     * @return array|bool
     */
    public function getColumns()
    {

        $data = $this->readFirstLine();

        if($data) {

            if($this->headLine) {

                return $data;


            } else {

                $keys = range(0, count($data)-1);

                return array_combine($keys, $keys);

            }

        }

        return [];
    }

    /**
     * Загружает сопоставление колонок и атрибутов на основе csv файла
     */
    public function loadMapping()
    {
        if($this->headLine) {

            $columns = $this->getColumns();

            $importModel = Yii::$app->getModule('import')->csvImporter->createImportModel($this->modelClass);

            foreach($columns as $index => $attr) {

                $csvAttrs = $importModel->getCsvAttributes();

                if(!in_array($attr, $csvAttrs))
                    continue;

                $this->mapping[$attr] = $index;

            }

        }
    }

} 
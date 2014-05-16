<?php

namespace common\helpers;

use yii\helpers\FileHelper AS YiiFileHelper;

/**
 * Class FileHelper
 * Содержит методы для аботы с файлами
 * @package common\helpers
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class FileHelper extends YiiFileHelper{

    /**
     * Возвращает расширение файла или false, если оно отсутствует
     * @param string $path путь к файлу
     * @param boolean $lower приводить ли к нижнему регистру расширение
     * @return string|boolean
     */

    public static function getExtension($path, $lower = true) {

        $arr = explode(".", $path);

        if(count($arr) <= 1)
            return false;

        $ext = end($arr);

        if($lower)
            $ext = strtolower($ext);

        return $ext;

    }

    /**
     * Производит транслит имени файла с русского на латинский
     * @param string $name имя файла
     * @return string
     */

    public static function ruTranslit($name) {

        $tr = array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
            "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
            "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
            "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
            "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
            "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
            "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=> "_", "/"=> "_", ")"=>"", "("=>"",
            "&"=>"", "?"=>"", "%"=>"", ","=>"", "$"=>"", ";"=>"",
            ":"=>"", "<"=>"", ">"=>"", "*"=>"", "+"=>"", "="=>"",
            "@"=>"", "#"=>"", "№"=>"", "!"=>"", "^"=>"", "'"=>"", "\""=>""
        );

        return strtr($name,$tr);

    }

    /**
     * Возвращает свободное имя файла для сохранения
     * @param string $path путь к папке для сохранения
     * @param string $name исходное имя файла
     * @return string
     */

    public static function getNameForSave($path, $name) {

        $last = substr($path, -1);

        if($last != DIRECTORY_SEPARATOR)
            $path .= DIRECTORY_SEPARATOR;

        $fp = explode(".", $name);

        $ext = (count($fp)>1)?array_pop($fp):null;

        $fileName = implode(".", $fp);

        $fileName = static::ruTranslit($fileName);

        $newFileName = $fileName;

        $i = 0;

        $extWithDot = $ext?".".$ext:null;

        while (file_exists($path . $newFileName . $extWithDot)) {

            $i++;

            $newFileName = $fileName . "_" . $i;
        }

        return $newFileName . $extWithDot;

    }


}
<?php

namespace app\modules\main\models;

use common\components\Match;
use Yii;
use common\db\ActiveRecord;
use yii\db\ActiveQueryInterface;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class IncludeGroup
 * Группа включаемых областей
 * @property string $includesIdsStr
 * @property array $includesIds
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class IncludeGroup extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    protected $_includesMap;

    protected $_includesIdsStr;

    protected $_includesIds;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "include_groups";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\IncludeGroupMeta::className();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $arr = parent::behaviors();

        $arr["manyManySaver"] = [
            'class' => \common\behaviors\ManyManySaver::className(),
            'names' => ['includes'],
        ];

        $arr["matchSuitable"] = \common\behaviors\MatchSuitable::className();

        return $arr;
    }

    /**
     * @return array
     */
    public function getIncludesIds()
    {

        if($this->_includesIds === null) {

            $this->_includesIds = $this->getManyManyIds("includes");

        }

        return $this->_includesIds;
    }

    /**
     * @param array $includesIds
     */
    public function setIncludesIds($includesIds)
    {
         $this->_includesIds = $includesIds;
    }

    /**
     * @return string
     */
    public function getIncludesIdsStr()
    {

        if($this->_includesIdsStr === null) {

            $this->_includesIdsStr = Yii::$app->getModule('main')->tagsConverter->arrayToTags($this->includes);

        }

        return $this->_includesIdsStr;
    }

    /**
     * @param string $includesIdsStr
     */
    public function setIncludesIdsStr($includesIdsStr)
    {

        $arr = Yii::$app->getModule('main')->tagsConverter->tagsToArray($includesIdsStr);

        $this->setIncludesIds($arr);

        $this->_includesIdsStr = $includesIdsStr;
    }

    /**
     * Связь с включаемымы областями
     * @return ActiveQueryInterface
     */
    public function getIncludes()
    {

        return $this->hasMany(Includes::className(), ['id' => 'include_id'])
            ->viaTable('groups_to_includes', ['group_id' => 'id']);

    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $val = parent::__get($name);

        if($name == "includes" AND !empty($val)) {

            $this->sortIncludes($val, $this->id);

        }

        return $val;

    }


    /**
     * Сортировка включаемых областей
     * @param Includes[] $includes включаемые области
     * @param int $id идентификатор модели
     */
    public function sortIncludes(&$includes, $id)
    {

        $map = $this->getIncludesMap($id);

        uasort($includes, function($val1, $val2) use ($map){

            $key1 = array_search($val1->id, $map);
            $key2 = array_search($val2->id, $map);

            if($key1>$key2)
                return 1;
            elseif($key1<$key2)
                return -1;
            else
                return 0;


        });

    }

    /**
     * Вормирует массив для сортировки включаемых областей
     * @param int $id идентификатор группы
     * @return array
     */
    public function getIncludesMap($id)
    {

        if($this->_includesMap === null) {

            $query = new Query();

            $rows = $query->select(["id", "include_id"])->from("groups_to_includes")->andWhere(["group_id" => $id])->orderBy(["id" => SORT_ASC])->all();

            $this->_includesMap = ArrayHelper::map($rows, "id", "include_id");

        }

        return $this->_includesMap;

    }




}
<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 10.12.15
 * Time: 17:24
 */

namespace common\components;

use common\db\TActiveRecord;
use Yii;
use yii\validators\Validator;

/**
 * Class TreeUniqueValidator
 * Валидатор уникальности в зависимости от положения в иерархии
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TreeUniqueValidator extends Validator
{

    public $parentIdAttr = "parent_id";

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} "{value}" has already been taken.');
        }
    }

    public function validateAttribute($model, $attribute)
    {

        $parentId = $this->parentIdAttr;

        if($model->$parentId) {

            $parent = $model->findOne($model->$parentId);

        } else {

            $parent = $model->findOne(TActiveRecord::ROOT_ID);

        }

        $query = $parent->children(1)->andWhere([$attribute=>$model->$attribute]);

        if($model->id) {

            $query->andWhere(["!=", "id", $model->id]);

        }

        $query->orderBy(null);

        if ($query->count()>0) {
            $this->addError($model, $attribute, $this->message);
        }
    }
}
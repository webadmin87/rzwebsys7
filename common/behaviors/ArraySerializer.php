<?php
namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * Class ArraySerializer
 * Серилизует в JSON значение атрибута (массив) для сохранения в БД
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ArraySerializer extends Behavior
{

	/**
	 * @var string имя атрибута значение которого необходимо серилизовать
	 */
	public $attribute;

	/**
	 * @inheritdoc
	 */
	public function events()
	{

		return [

			ActiveRecord::EVENT_BEFORE_INSERT => "beforeSave",
			ActiveRecord::EVENT_BEFORE_UPDATE => "beforeSave",
			ActiveRecord::EVENT_AFTER_INSERT => "afterSave",
			ActiveRecord::EVENT_AFTER_UPDATE => "afterSave",
			ActiveRecord::EVENT_AFTER_FIND => "afterFind",
		];

	}

	/**
	 * Инициализация
	 * @throws InvalidConfigException
	 */
	public function init()
	{
		if(empty($this->attribute))
			throw new InvalidConfigException("Class property 'attribute' does`t set");

		parent::init();
	}

	/**
	 * Десерилизуем
	 * @return bool
	 * @throws \yii\base\InvalidParamException
	 */
	public function  afterFind()
	{
		$attr = $this->attribute;

		if(empty($this->owner->$attr))
			$this->owner->$attr = [];
		else
			$this->owner->$attr = Json::decode($this->owner->$attr);

		return true;
	}

	/**
	 * Серилизуем
	 * @return bool
	 */
	public function beforeSave()
	{
		$attr = $this->attribute;

		$arr = is_array($this->owner->$attr)?$this->owner->$attr:[];

		$this->owner->$attr = Json::encode($arr);

		return true;
	}

	/**
	 * Десерелизуем
	 * @return bool
	 * @throws \yii\base\InvalidParamException
	 */
	public function afterSave()
	{
		$attr = $this->attribute;

		$this->owner->$attr = Json::decode($this->owner->$attr);

		return true;
	}

}
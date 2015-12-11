<?php

namespace app\modules\main\db;

use common\db\ActiveQuery;

/**
 * Class ReviewQuery
 * @package app\modules\main\db
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewQuery extends ActiveQuery
{

	/**
	 * Выборка по модели для которой создавался отзыв
	 * @param integer $itemId ID модели
	 * @param string $modelClass класс модели
	 * @return $this
	 */
	public function byItem($itemId, $modelClass)
	{
		$this->andWhere([
			"{{%$this->tableName}}.{{%item_id}}" => $itemId,
			"{{%$this->tableName}}.{{%model}}" => $modelClass,
		]);
		return $this;
	}

	/**
	 * Выборка по модели, по которой создавался отзыв
	 * @param integer $itemId ID модели
	 * @param string $modelClass класс модели
	 * @return $this
	 */
	public function bySourceItem($itemId, $modelClass)
	{
		$this->andWhere([
			"{{%$this->tableName}}.{{%source_item_id}}" => $itemId,
			"{{%$this->tableName}}.{{%source_model}}" => $modelClass,
		]);
		return $this;
	}

}
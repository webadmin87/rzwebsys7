<?php

namespace app\modules\main\rbac;

use yii\base\Object;
use common\rbac\IConstraint;
use app\modules\main\models\Review;

/**
 * Class ReviewConstraint
 * Ограничение на операции с отзывами
 * @package app\modules\main\rbac
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewConstraint extends Object implements IConstraint
{
	/**
	 * @inheritdoc
	 */
	public function applyConstraint($query)
	{

	}

	/**
	 * @inheritdoc
	 * @param Review $model
	 */
	public function create($model)
	{

		if (empty($model->model) or empty($model->item_id) or empty($model->source_model) or empty($model->source_item_id)) {
			return false;
		}

		$exists = Review::find()
			->byItem($model->item_id, $model->model)
			->bySourceItem($model->source_item_id, $model->source_model)
			->count();

		return !$exists;
	}

	/**
	 * @inheritdoc
	 * @param Review $model
	 */
	public function read($model)
	{
		return true;
	}

	/**
	 * @inheritdoc
	 * @param Review $model
	 */
	public function update($model)
	{
		return true;
	}

	/**
	 * @inheritdoc
	 * @param Review $model
	 */
	public function delete($model)
	{
		return true;
	}
}
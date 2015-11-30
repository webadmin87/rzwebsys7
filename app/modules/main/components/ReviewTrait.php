<?php


namespace app\modules\main\components;


use app\modules\main\models\Review;

/**
 * Class ReviewTrait
 * @property Review[] $reviews отзывы
 * @property-read Review $review один отзыв
 * @property-read float $rating средний рейтинг
 * @property-read float $totalRaiting суммарный рейтинг
 * @package app\modules\main\components
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
trait ReviewTrait
{
	/**
	 * @var Review один запрос для модели
	 */
	protected $_review;

	/**
	 * Связь с отзывами
	 * @return Review[]
	 */
	public function getReviews()
	{
		return $this->hasMany(Review::className(), ['item_id' => 'id'])->where(['model' => get_class()]);
	}

	/**
	 * Один отзыв
	 * @return Review
	 */
	public function getReview()
	{
		if (is_null($this->_review)) {
			$this->_review = $this->getReviews()->limit(1)->one();
		}

		return $this->_review;
	}

	/**
	 * Возвращает средний рейтинг
	 * @return float
	 */
	public function getRating()
	{
		return round($this->review->rating_average, 2);

	}

	/**
	 * Возвращает средний рейтинг
	 * @return float
	 */
	public function getTotalRating()
	{
		return round($this->review->rating_total, 2);

	}

}
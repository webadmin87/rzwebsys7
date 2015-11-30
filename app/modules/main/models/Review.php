<?php
namespace app\modules\main\models;

use Yii;
use common\db\ActiveRecord;
use app\modules\main\db\ReviewQuery;

/**
 * Class Review
 * Модель отзывов
 * @property string $username имя пользователя
 * @property string $email электронная почта пользователя
 * @property float $rating оценка
 * @property string $text отзыв
 * @property string $model имя класса модели, для которой отзыв
 * @property integer $item_id ID модели, для которой отзыв
 * @property string $source_model имя класса модели, по которой создан отзыв
 * @property integer $source_item_id ID модели, по которой создан отзыв
 * @property integer $count количкство откликов ддля модели
 * @property float $rating_total суммарный рейтинг для модели
 * @property float $rating_average средний рейтинг для модели
 * @package app\modules\main\models
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class Review extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();

        if ($this->isNewRecord AND $this->scenario == ActiveRecord::SCENARIO_INSERT AND !Yii::$app->user->isGuest) {
            $this->username = Yii::$app->user->identity->username;
            $this->email = Yii::$app->user->identity->email;
        }

    }

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\ReviewMeta::className();
    }

    /**
     * @inheritdoc
     * @return ReviewQuery
     */
    public static function find()
    {
        return Yii::createObject(ReviewQuery::className(), [get_called_class()]);
    }

	/**
	 * @inheritdoc
	 */
	public function afterSave($insert, $changedAttributes)
	{

		if ($insert and $this->active == true) {
			$this->recalc();
		}

		if (!$insert and isset($changedAttributes['active'])) {
			$this->recalc();
		}

		parent::afterSave($insert, $changedAttributes);

	}

	/**
	 * Пересчитывает количество отзывов, суммарный и средний рейтинги
	 */
	protected function recalc() {

		$query = self::find()->byItem($this->item_id, $this->model);

		self::updateAll([
			'count' => $query->count(),
			'rating_total' => $query->sum('rating'),
			'rating_average' => $query->average('rating')
		], $query->where);

	}

}
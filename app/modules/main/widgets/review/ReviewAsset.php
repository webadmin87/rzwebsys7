<?php

namespace app\modules\main\widgets\review;

use common\components\AssetBundle;

/**
 * Class ReviewAsset
 * Ассет для добавления отзыва
 * @package app\modules\main\widgets\review
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/script.js',
	];

	/**
	 * @inheritdoc
	 */
	public $jsMin = [
		'js/script.min.js',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		$this->sourcePath = __DIR__ . "/assets";
		parent::init();
	}
}
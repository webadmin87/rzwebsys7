<?php

namespace app\modules\geo\controllers;

use app\modules\geo\models\Region;
use app\modules\geo\models\Rajon;
use app\modules\geo\models\Np;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ListController
 * Контроллер вывода html для заполнения связанных списков географического справочника
 * @package app\modules\geo\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListController extends Controller
{

	/**
	 * Рендерит html регионов для dropdown
	 * @param int $id идентификатор страны
	 * @throws \yii\base\ExitException
	 */
	public function actionRegions($id)
    {

		$all = Region::find()->published()->where(["country_id"=>$id])->orderBy(["title"=>SORT_ASC])->all();

		$o = ["prompt"=>""];

		echo Html::renderSelectOptions(null, ArrayHelper::map($all, "id", "title"), $o);

		Yii::$app->end();

    }

	/**
	 * Рендерит html районов для dropdown
	 * @param int $id идентификатор региона
	 * @throws \yii\base\ExitException
	 */
	public function actionRajons($id)
	{

		$all = Rajon::find()->published()->where(["region_id"=>$id])->orderBy(["title"=>SORT_ASC])->all();

		$o = ["prompt"=>""];

		echo Html::renderSelectOptions(null, ArrayHelper::map($all, "id", "title"), $o);

		Yii::$app->end();

	}

	/**
	 * Рендерит html населенных пунктов для dropdown
	 * @param int $id идентификатор района
	 * @throws \yii\base\ExitException
	 */
	public function actionNps($id)
	{

		$all = Np::find()->published()->where(["rajon_id"=>$id])->orderBy(["title"=>SORT_ASC])->all();

		$o = ["prompt"=>""];

		echo Html::renderSelectOptions(null, ArrayHelper::map($all, "id", "title"), $o);

		Yii::$app->end();

	}
}

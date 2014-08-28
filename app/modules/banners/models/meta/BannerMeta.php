<?php
namespace app\modules\banners\models\meta;

use Yii;
use common\db\MetaFields;
use \app\modules\banners\models\Place;
use yii\helpers\ArrayHelper;

/**
 * Class BannerMeta
 * Мета описание модели баннера
 * @package app\modules\banners\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BannerMeta extends MetaFields
{


	/**
	 * Возвращает массив для привязкт к баннерным местам
	 * @return array
	 */
	public function getPlaces()
	{

		$models = Place::find()->published()->orderBy(["title"=>SORT_ASC])->all();

		return ArrayHelper::map($models, "id", "title");

	}

    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('banners/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

			"place_id" => [
				"definition" => [
					"class" => \common\db\fields\HasOneField::className(),
					"title" => Yii::t('banners/app', 'Place'),
					"data" => [$this, "getPlaces"],
					"isRequired" => true,
				],
				"params" => [$this->owner, "place_id", "place"]
			],

			"image" => [
				"definition" => [
					"class" => \common\db\fields\Html5FileField::className(),
					"title" => Yii::t('banners/app', 'File'),
				],
				"params" => [$this->owner, "image"]
			],

			"link" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('banners/app', 'Link'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "link"]
			],

			"target" => [
				"definition" => [
					"class" => \common\db\fields\ListField::className(),
					"title" => Yii::t('banners/app', 'Target'),
					"showInGrid"=>false,
					"data"=>["\\app\\modules\\banners\\models\\Banner", "getTargets"],
				],
				"params" => [$this->owner, "target"]
			],

			"text" => [
				"definition" => [
					"class" => \common\db\fields\TextAreaField::className(),
					"title" => Yii::t('banners/app', 'Text'),
				],
				"params" => [$this->owner, "text"]
			],

			"width" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('banners/app', 'Width'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "width"]
			],

			"height" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('banners/app', 'Height'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "height"]
			],

			"sort" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('banners/app', 'Sort'),
					"showInGrid"=>true,
					"editInGrid"=>true,
				],
				"params" => [$this->owner, "sort"]
			],

        ];
    }

}
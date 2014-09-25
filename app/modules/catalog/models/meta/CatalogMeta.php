<?php

namespace app\modules\catalog\models\meta;

use app\modules\catalog\models\CatalogSection;
use app\modules\catalog\models\Producer;
use common\db\MetaFields;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class CatalogMeta
 * Мета описание модели элемента каталога
 * @package app\modules\catalog\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogMeta extends MetaFields
{

    const SEO_TAB = "seo";

    /**
     * @inheritdoc
     */

    public function tabs()
    {
        $tabs = parent::tabs();
        $tabs[self::SEO_TAB] = Yii::t('catalog/app', "SEO");
        return $tabs;
    }

    /**
     * Возвращает категории каталога для dropDown
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getSectionsList()
    {
        $model = \Yii::createObject(CatalogSection::className());
        return $model->getDataByParent();
    }

	/**
	 * Возвращает список производителей для выпадающего списка
	 * @return array
	 */
	public function getProducersList()
	{
		$models = Producer::find()->published()->orderBy(["title"=>SORT_ASC])->all();

		return ArrayHelper::map($models, "id", "title");

	}


    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "sections" => [
                "definition" => [
                    "class" => \common\db\fields\ManyManyField::className(),
                    "title" => Yii::t('catalog/app', 'Catalog Sections'),
                    "isRequired" => true,
                    "data" => [$this, "getSectionsList"],
                ],
                "params" => [$this->owner, "sectionsIds", "sections"]
            ],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('catalog/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('catalog/app', 'Code'),
                    "isRequired" => true,
                    "showInGrid" => false,
                ],
                "params" => [$this->owner, "code"]
            ],

            "comments" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('catalog/app', 'Comments'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "comments"]
            ],

            "price" => [
                "definition" => [
                    "class" => \common\db\fields\NumberField::className(),
                    "title" => Yii::t('catalog/app', 'Price'),
                    "isRequired" => false,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "price"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('catalog/app', 'Image'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "image"]
            ],

            "annotation" => [
                "definition" => [
                    "class" => \common\db\fields\TextAreaField::className(),
                    "title" => Yii::t('catalog/app', 'Annotation'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "annotation"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('catalog/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],

			"producer_id" => [
				"definition" => [
					"class" => \common\db\fields\HasOneField::className(),
					"title" => Yii::t('catalog/app', 'Producer'),
					"isRequired" => false,
					"showInGrid" => false,
				],
				"params" => [$this->owner, "producer_id", "producer"],
			],

            "metatitle" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('catalog/app', 'Meta title'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "metatitle"]
            ],

            "keywords" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('catalog/app', 'Keywords'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "keywords"]
            ],

            "description" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('catalog/app', 'Description'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "description"]
            ],

        ];
    }

}
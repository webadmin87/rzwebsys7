<?php

namespace app\modules\catalog\models\meta;

use common\db\MetaFields;
use Yii;

/**
 * Class CatalogSectionMeta
 * Мета описание модели категорий каталога
 * @package app\modules\catalog\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogSectionMeta extends MetaFields
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
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "parent_id" => [
                "definition" => [
                    "class" => \common\db\fields\ParentListField::className(),
                    "title" => Yii::t('main/app', 'Parent'),
                    "data" => [$this->owner, 'getListTreeData'],
                ],
                "params" => [$this->owner, "parent_id"]
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
                ],
                "params" => [$this->owner, "code"]
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
<?php
namespace app\modules\catalog\models\meta;

use Yii;
use common\db\MetaFields;

class ProducerMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

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

        ];
    }

}
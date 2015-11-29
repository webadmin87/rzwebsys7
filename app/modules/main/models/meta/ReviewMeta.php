<?php

namespace app\modules\main\models\meta;

use Yii;
use common\db\fields;
use common\db\MetaFields;
use common\inputs\RatingInput;

/**
 * Class ReviewMeta
 * Мета-описание модели отзыва
 * @package app\modules\module_name\models\meta
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewMeta extends MetaFields
{
    /**
     * @inheritdoc
     */
    protected function config()
    {
        return [

            'active' => [
                'definition' => [
                    'initValue' => false,
                ],
            ],

            'username' => [
                'definition' => [
                    'class' => fields\TextField::className(),
                    'title' => Yii::t('main/app', 'Username'),
                    'isRequired' => true,
                ],
                'params' => [$this->owner, 'username']
            ],

            'email' => [
                'definition' => [
                    'class' => fields\EmailField::className(),
                    'title' => Yii::t('main/app', 'Email'),
                    'isRequired' => false,
                    'showInGrid' => false
                ],
                'params' => [$this->owner, 'email']
            ],

            'rating' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Rating'),
                    'min' => 0,
                    'max' => 5,
                    'isRequired' => true,
                    'editInGrid' => true,
                    'inputClass' => [
                        'class' => RatingInput::className(),
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'min' => 0,
                                'max' => 5,
                                'stars' => 5,
                                'step' => 1,
                                'size' => 'sm',
                                'showClear' => false,
                                'showCaption' => false,
                            ]
                        ],
                    ],
                ],
                'params' => [$this->owner, 'rating']
            ],

            'text' => [
                'definition' => [
                    'class' => fields\TextAreaField::className(),
                    'title' => Yii::t('main/app', 'Review'),
                    'isRequired' => true,
                    'showInGrid' => true,
                ],
                'params' => [$this->owner, 'text']
            ],

            'model' => [
                'definition' => [
                    'class' => fields\TextField::className(),
                    'title' => Yii::t('main/app', 'Model class'),
                    'isRequired' => true,
                ],
                'params' => [$this->owner, 'model']
            ],

            'item_id' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Item id'),
                    'isRequired' => true,
                ],
                'params' => [$this->owner, 'item_id']
            ],

            'source_model' => [
                'definition' => [
                    'class' => fields\TextField::className(),
                    'title' => Yii::t('main/app', 'Model class'),
                    'isRequired' => true,
                ],
                'params' => [$this->owner, 'source_model']
            ],

            'source_item_id' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Item id'),
                    'isRequired' => true,
                ],
                'params' => [$this->owner, 'source_item_id']
            ],

            'count' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Reviews Count'),
                    'isRequired' => true,
                    'initValue' => 0,
                    'showInForm' => false,
                ],
                'params' => [$this->owner, 'count']
            ],

            'rating_total' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Rating Total'),
                    'isRequired' => true,
                    'initValue' => 0,
                    'showInForm' => false,
                ],
                'params' => [$this->owner, 'rating_total']
            ],

            'rating_average' => [
                'definition' => [
                    'class' => fields\NumberField::className(),
                    'title' => Yii::t('main/app', 'Rating Average'),
                    'isRequired' => true,
                    'initValue' => 0,
                    'showInForm' => false,
                ],
                'params' => [$this->owner, 'rating_average']
            ],

        ];
    }

}
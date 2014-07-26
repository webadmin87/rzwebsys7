<?php
namespace app\modules\main\models;

use yii\base\Model;

/**
 * Class FeedbackForm
 * Модель формы обратной связи
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class FeedbackForm extends Model {

    /**
     * @var string имя
     */
    public $name;

    /**
     * @var string email
     */
    public $email;

    /**
     * @var string email
     */
    public $phone;

    /**
     * @var string текст сообщения
     */
    public $text;

    /**
     * @return array
     */
    public function rules() {

        return [

            [['name', 'email', 'text'], 'required'],
            ['email', 'email'],
            ['phone', 'number', 'integerOnly'=>true, 'min'=>10],

        ];

    }

}
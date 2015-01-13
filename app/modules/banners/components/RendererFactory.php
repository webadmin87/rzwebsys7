<?php
namespace app\modules\banners\components;

use yii\base\Object;
use Yii;

/**
 * Class RendererFactory
 * Фабрика создающая компоненты для рендера баннеров
 * @package app\modules\banners\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class RendererFactory extends Object
{

    /**
     * Возвращает объект для рендера баннера
     * @param \app\modules\banners\models\Banner $model модель баннера
     * @return null|AbstractRenderer
     * @throws \yii\base\InvalidConfigException
     */
    public function createRenderer(\app\modules\banners\models\Banner $model)
    {

        $file = $model->getFirstFile('image');

        if(!$file)
            return null;

        if($file->isImage())
            return Yii::createObject(ImageRenderer::className(), [$model]);
        else
            return Yii::createObject(FlashRenderer::className(), [$model]);

    }

}
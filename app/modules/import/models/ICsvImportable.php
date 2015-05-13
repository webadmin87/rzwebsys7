<?php

namespace app\modules\import\models;

/**
 * Interface ICsvImportable
 * Интерфейс который должна реализовать модель, чтобы обеспечить импорт из CSV
 * @package app\modules\import\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
interface ICsvImportable
{

    /**
     * Возвращает массив атрибутов доступных для импорта из csv
     * @return array
     */
    public function getCsvAttributes();

} 
<?php
namespace common\db;

/**
 * Class CreatedAtSearchTrait
 * Добавляет атрибуты для поиска по диапазону даты создания
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
trait CreatedAtSearchTrait
{

    protected $_createdAtFrom;
    protected $_createdAtTo;

    /**
     * @return mixed
     */
    public function getCreatedAtFrom()
    {
        return $this->_createdAtFrom;
    }

    /**
     * @param mixed $createdAtFrom
     */
    public function setCreatedAtFrom($createdAtFrom)
    {
        $this->_createdAtFrom = $createdAtFrom;
    }

    /**
     * @return mixed
     */
    public function getCreatedAtTo()
    {

        if(!empty($this->_createdAtTo))
            return $this->_createdAtTo;
        else
            return $this->_createdAtTo;

    }

    /**
     * @param mixed $createdAtTo
     */
    public function setCreatedAtTo($createdAtTo)
    {
        $this->_createdAtTo = $createdAtTo;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\interfaces;


abstract class IHasID
{
    /**
     * @var string
     */
    protected           $_id        = 0;

    public function __construct()
    {
        $this->_id = str_replace("." , "", uniqid(get_class($this)."_", true));
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->_id;
    }
}
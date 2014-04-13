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
     * @var int
     */
    protected static    $_next_id   = 0;

    /**
     * @var int
     */
    protected           $_id        = 0;

    public function __construct()
    {
        $this->_id = self::$_next_id++;
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->_id;
    }
}
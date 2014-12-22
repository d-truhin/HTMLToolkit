<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\Interfaces;


/**
 * Class which implements a unique ID generation
 *
 * @package SMelukov\HTMLToolkit\Interfaces
 */
interface IHasID
{
    /**
     * Get ID
     *
     * @return string
     */
    function getID();
}
<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 23.12.14
 * Time: 1:16
 */

namespace SMelukov\HTMLToolkit\Traits;


/**
 * Trait HasID
 * Implement ID getter thru spl_object_hash()
 *
 * @package SMelukov\HTMLToolkit\Traits
 */
trait HasID
{
    /**
     * @return string
     */
    function getID()
    {
        return spl_object_hash($this);
    }
}
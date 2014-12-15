<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\interfaces;


/**
 * Class which implements a unique ID generation
 *
 * @package SMelukov\HTMLToolkit\interfaces
 */
abstract class IHasID
{
    /**
     * @var string
     */
    protected $_id = "";

    /**
     *
     */
    public function __construct()
    {
        $this->_id = $this->UID();
    }

    /**
     * Generate UID
     *
     * @return string
     */
    public static function UID()
    {
        return str_replace(".", "", uniqid(get_called_class() . "_", true));
    }

    /**
     * Get ID
     *
     * @return string
     */
    public function getID()
    {
        return $this->_id;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 04.06.14
 * Time: 23:52
 */

namespace SMelukov\HTMLToolkit\Tools;


/**
 * Another countable string implementation
 *
 * @package SMelukov\HTMLToolkit\Tools
 */
class String implements \Iterator, \Countable
{
    /**
     * @var string
     */
    protected $_target = '';
    /**
     * @var int
     */
    protected $_index = 0;

    function __construct($target)
    {
        $this->_target = $target;
    }

    function __toString()
    {
        return $this->_target;
    }

    /** {@inheritdoc} */
    public function current()
    {
        return substr($this->_target, $this->_index, 1);
    }

    /** {@inheritdoc} */
    public function next()
    {
        $this->_index++;
    }

    /** {@inheritdoc} */
    public function key()
    {
        return $this->_index;
    }

    /** {@inheritdoc} */
    public function valid()
    {
        return $this->_index <= strlen($this->_target);
    }

    /** {@inheritdoc} */
    public function rewind()
    {
        $this->_index = 0;
    }

    /** {@inheritdoc} */
    public function count()
    {
        strlen($this->_target);
    }
}
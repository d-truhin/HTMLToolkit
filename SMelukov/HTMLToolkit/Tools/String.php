<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 04.06.14
 * Time: 23:52
 */

namespace SMelukov\HTMLToolkit\Tools;


class String implements \Iterator, \Countable
{
    protected $_target = '';
    protected $_index = 0;

    function __construct($target)
    {
        $this->_target = $target;
    }

    function __toString()
    {
        return $this->_target;
    }

    public function current()
    {
        return substr($this->_target, $this->_index, 1);
    }

    public function next()
    {
        $this->_index++;
    }

    public function key()
    {
        return $this->_index;
    }

    public function valid()
    {
        return $this->_index <= strlen($this->_target);
    }

    public function rewind()
    {
        $this->_index = 0;
    }

    public function count()
    {
        strlen($this->_target);
    }
}
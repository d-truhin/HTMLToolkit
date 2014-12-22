<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 10:56
 */

namespace SMelukov\HTMLToolkit\Interfaces;


/**
 * Class IGroup
 * @package SMelukov\HTMLToolkit\Interfaces
 */
abstract class IGroup implements \Countable, \Iterator, \ArrayAccess
{
    /**
     * @var string
     */
    protected $_name = '';
    /** @var IHasID[] */
    protected $_elements      = [];
    private   $_iteratorIndex = 0;

    /**
     * @param string $name name of the group
     * @param IHasID[]|IHasID $elements elements which will be added to this group
     */
    public function __construct($name, $elements = [])
    {
        $this->_name = $name;
        if (!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach ($elements as $element) {
            $this->_elements[$element->getID()] = $element;
        }
    }

    /**
     * Call some method for all element in the group
     *
     * @param $name
     * @param $arguments
     * @return IGroup
     */
    function __call($name, $arguments)
    {
        foreach ($this->_elements as $element) {
            if (method_exists($element, $name)) {
                call_user_func_array([$element, $name], $arguments);
            }
        }
        return $this;
    }

    /**
     * Like jQuery each :)
     *
     * @param callable $callback
     * @return IGroup
     */
    public function each($callback = null)
    {
        if (is_callable($callback)) {
            /** @var $element IHasID */
            foreach (array_values($this->_elements) as $index => $element)
                call_user_func_array($callback, [$element, $index]);
        }
        return $this;
    }

    /**
     * Get name of the group
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get elements in the group
     *
     * @param bool $idInKeys
     * @return IHasID[]
     */
    public function getElementsList($idInKeys = false)
    {
        if ($idInKeys)
            return $this->_elements;
        return array_values($this->_elements);
    }

    /**
     * Add element to the group
     *
     * @param IHasID[]|IHasID $elements
     * @return $this
     */
    public function addElements($elements)
    {
        if (!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach ($elements as $element) {
            $this->_elements[$element->getID()] = $element;
        }
        return $this;
    }

    /**
     * Delete element from the group
     *
     * @param IHasID[] $elements one (or more) element to delete
     */
    public function deleteElement($elements)
    {
        if (!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach ($elements as $element) {
            if (isset($this->_elements[$element->getID()]))
                unset($this->_elements[$element->getID()]);
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return array_values($this->_elements)[$this->_iteratorIndex];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_iteratorIndex++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->_iteratorIndex;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset(array_values($this->_elements)[$this->_iteratorIndex]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_iteratorIndex = 0;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->_elements);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset(array_values($this->_elements)[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return array_values($this->_elements)[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        // forced empty
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        foreach ($this->_elements as $key => $val) {
            static $i = 0;
            if ($i++ == $offset) {
                unset($this->_elements[$offset]);
            }
        }
    }


} 
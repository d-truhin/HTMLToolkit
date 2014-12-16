<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 10:56
 */

namespace SMelukov\HTMLToolkit\interfaces;


/**
 * Class IGroup
 * @package SMelukov\HTMLToolkit\interfaces
 */
abstract class IGroup
{
    /**
     * @var string
     */
    protected $_name = '';
    /** @var IHasID[] */
    protected $_elements = [];

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
     * @param IHasID[] $elements
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
} 
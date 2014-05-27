<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 10:56
 */

namespace SMelukov\HTMLToolkit\interfaces;


abstract class IGroup
{
    protected $_name = '';
    /** @var IHasID[] */
    protected $_elements = array();

    /**
     * @param $name
     * @param $arguments
     * @return IGroup
     */
    function __call($name, $arguments)
    {
        foreach($this->_elements as $element)
        {
            if(method_exists($element, $name))
            {
                call_user_func_array(array($element, $name), $arguments);
            }
        }
        return $this;
    }

    public function __construct($name, $elements = array())
    {
        $this->_name    = $name;
        if(!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach($elements as $element)
        {
            $this->_elements[$element->getID()]= $element;
        }
    }

    /**
     * @param callable $callback
     * @return IGroup
     */
    public function each($callback = null)
    {
        if(is_callable($callback))
        {
            /** @var $element IHasID */
            foreach(array_values($this->_elements) as $index=>$element)
                call_user_func_array($callback, array($element, $index));
        }
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param bool $idInKeys
     * @return IHasID[]
     */
    public function getElementsList($idInKeys = false)
    {
        if($idInKeys)
            return $this->_elements;
        return array_values($this->_elements);
    }

    public function addElements($elements)
    {
        if(!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach($elements as $element)
        {
            $this->_elements[$element->getID()]= $element;
        }
        return $this;
    }

    public function deleteElement($elements)
    {
        if(!is_array($elements))
            $elements = [$elements];
        /** @var $element IHasID */
        foreach($elements as $element)
        {
            if(isset($this->_elements[$element->getID()]))
                unset($this->_elements[$element->getID()]);
        }
    }
} 
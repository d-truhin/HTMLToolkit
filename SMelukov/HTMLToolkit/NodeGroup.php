<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 10:56
 */

namespace SMelukov\HTMLToolkit;


use SMelukov\HTMLToolkit\interfaces\IWebNode;

class NodeGroup
{
    protected $_name = '';
    /** @var HTMLTag[] */
    protected $_elements = array();

    /**
     * @param $name
     * @param $arguments
     * @return HTMLTag
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
        /** @var $element HTMLTag */
        foreach($elements as $element)
        {
            if(is_a($element, 'SMelukov\HTMLToolkit\interfaces\IWebNode'))
                $this->_elements[$element->getID()]= $element;
        }
    }

    /**
     * @param callable $callback
     * @return HTMLTag
     */
    public function each($callback = null)
    {
        if(is_callable($callback))
        {
            /** @var $element HTMLTag */
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
     * @return HTMLTag[]
     */
    public function getElementsList($idInKeys = false)
    {
        if($idInKeys)
            return $this->_elements;
        return $this->_elements;
    }

    public function addElements($elements)
    {
        if(!is_array($elements))
            $elements = [$elements];
        /** @var $element HTMLTag */
        foreach($elements as $element)
        {
            if(is_a($element, 'SMelukov\HTMLToolkit\HTMLTag'))
                $this->_elements[$element->getID()]= $element;
        }
        return $this;
    }

    public function deleteElement($elements)
    {
        if(!is_array($elements))
            $elements = [$elements];
        /** @var $element HTMLTag */
        foreach($elements as $element)
        {
            if(is_a($element, 'SMelukov\HTMLToolkit\interfaces\HTMLTag') && isset($this->_elements[$element->getID()]))
                unset($this->_elements[$element->getID()]);
        }
    }
} 
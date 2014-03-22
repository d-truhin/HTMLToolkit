<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:15
 */

namespace SMelukov\HTMLToolkit;


trait IContainable
{
    private $_children = [];
    public function append(IWebNode $what)
    {
        if(!is_array($what))
            $what = [$what];
        /** @var IWebNode $element */
        foreach($what as $element)
        {
            $this->_children[$element->getID()] = $element;
        }
        return $this;
    }

    public function remove(IWebNode $what)
    {
        if(isset($this->_children[$what->getID()]))
            unset($this->_children[$what->getID()]);
        return $this;
    }

    public function getChildrenList()
    {
        return $this->_children;
    }
} 
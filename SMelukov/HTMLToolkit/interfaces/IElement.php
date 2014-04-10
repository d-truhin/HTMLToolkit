<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\interfaces;


abstract class IElement
{
    /**
     * @var IElement null
     */
    protected           $_parent = null;

    /**
     * @var int
     */
    protected static    $_next_id   = 0;

    /**
     * @var int
     */
    protected           $_id        = 0;

    /**
     * @var IElement[]
     */
    private             $_children  = [];

    /**
     *
     */
    public function __construct()
    {
        $this->_id = self::$_next_id++;
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->_id;
    }

    /**
     * @return $this
     */
    public function parent()
    {
        return $this->_parent;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return ($this->_parent!=null);
    }

    public function remove()
    {
        if($this->_parent != null)
        {
            $this->_parent->removeChildren($this);
            $this->_parent = null;
        }
    }

    /**
     * @param IElement $what
     * @return $this
     */
    public function append(IElement $what)
    {
        $this->_children[$what->getID()] = $what;
        $what->_parent = $this;
        return $this;
    }

    /**
     * @param IElement $what
     * @return $this
     */
    public function prepend(IElement $what)
    {
        $this->append($what);
        $last = array_pop($this->_children);
        array_unshift($this->_children, $last);
        return $this;
    }

    /**
     * @return IElement[]
     */
    public function getChildrenList()
    {
        return $this->_children;
    }

    public function removeChildren(IElement $what)
    {
        if(isset($this->_children[$what->getID()]))
            unset($this->_children[$what->getID()]);
    }
} 
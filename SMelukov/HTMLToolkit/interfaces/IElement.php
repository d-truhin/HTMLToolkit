<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\interfaces;


abstract class IElement extends IHasID
{
    /**
     * @var IElement null
     */
    protected           $_parent = null;

    /**
     * @var IElement[]
     */
    private             $_children  = [];

    public function __construct()
    {
        parent::__construct();
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
     * @param bool $idInKeys
     * @return IElement[]
     */
    public function getChildrenList($idInKeys = false)
    {
        if($idInKeys)
            return $this->_children;
        return array_values($this->_children);
    }

    public function removeChildren(IElement $what)
    {
        if(isset($this->_children[$what->getID()]))
            unset($this->_children[$what->getID()]);
    }

    public function removeAllChildren()
    {
        /** @var $children IElement */
        foreach($this->getChildrenList() as $children)
            $this->removeChildren($children);

        return $this;
    }
}
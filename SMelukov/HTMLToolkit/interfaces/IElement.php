<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 22.03.14
 * Time: 15:49
 */

namespace SMelukov\HTMLToolkit\Interfaces;

use SMelukov\HTMLToolkit\Traits\HasID;


/**
 * Base class for all elements
 *
 * @package SMelukov\HTMLToolkit\Interfaces
 */
abstract class IElement implements IHasID
{
    use HasID;
    /**
     * @var IElement
     */
    protected $_parent = null;

    /**
     * @var IElement[]
     */
    private $_children = [];

    /**
     *
     */
    public function __construct()
    {
        //......
    }

    /**
     * @return mixed
     */
    abstract function __clone();

    /**
     * Get pointer to parent node
     *
     * @return IWebNode
     */
    public function parent()
    {
        return $this->_parent;
    }

    /**
     * Is this node has parent?
     *
     * @return bool
     */
    public function hasParent()
    {
        return ($this->_parent != null);
    }

    /**
     * Prepend a node to this node
     *
     * @param IElement $what what to prepend
     * @param bool $clone clone or move
     * @return $this
     */
    public function prepend(IElement $what, $clone = false)
    {
        $this->append($what, $clone);
        $last = array_pop($this->_children);
        array_unshift($this->_children, $last);
        return $this;
    }

    /**
     * Append a node to this node
     *
     * @param IElement $what what to prepend
     * @param bool $clone clone or move
     * @return $this
     */
    public function append(IElement $what, $clone = false)
    {
        $temp                            = $clone ? clone $what : $what->remove();
        $this->_children[$temp->getID()] = $temp;
        $temp->_parent                   = $this;
        return $this;
    }

    /**
     * Remove this node from parent node
     *
     * @return $this
     */
    public function remove()
    {
        if ($this->_parent) {
            $this->_parent->removeChildren($this);
        }
        return $this;
    }

    /**
     * Remove children from this node
     *
     * @param IElement $what
     * @return $this
     */
    public function removeChildren(IElement $what)
    {
        if (isset($this->_children[$what->getID()])) {
            $this->_children[$what->getID()]->_parent = null;
            unset($this->_children[$what->getID()]);
        }
        return $this;
    }

    /**
     * Remove all children from this node
     *
     * @return $this
     */
    public function removeAllChildren()
    {
        /** @var $children IElement */
        foreach ($this->getChildrenList() as $children)
            $this->removeChildren($children);

        return $this;
    }

    /**
     * Get children list of this node
     *
     * @param bool $idInKeys need or not node UID in result array keys
     * @return IElement[]
     */
    public function getChildrenList($idInKeys = false)
    {
        if ($idInKeys)
            return $this->_children;
        return array_values($this->_children);
    }
}
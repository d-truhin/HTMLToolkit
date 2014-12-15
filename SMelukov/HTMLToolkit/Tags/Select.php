<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 16.12.14
 * Time: 2:47
 */
use SMelukov\HTMLToolkit\interfaces\IWebNode;


/**
 * Simple "select" tag realization
 */
class Select extends \SMelukov\HTMLToolkit\HTMLTag
{
    /** @var Option[] */
    protected $_options = [];

    /**
     * Get selected options
     *
     * @return Option[]
     */
    function getSelected()
    {
        $res = [];
        foreach ($this->_options as $option) {
            if ($option->selected())
                $res[] = $option;
        }
        return $res;
    }

    /**
     * Add option to select
     *
     * @param Option $option
     * @return $this
     */
    function addOption($option)
    {
        $this->_options[$option->getId()] = $option;
        return $this;
    }

    /**
     * Remove option from select
     *
     * @param Option $option
     * @return $this
     */
    function removeOption($option)
    {
        if (isset($this->_options[$option->getId()]))
            unset($this->_options[$option->getId()]);
        return $this;
    }

    /**
     * Get list of all options of the select
     *
     * @return IWebNode[]
     */
    function getOptions()
    {
        return $this->getChildrenList();
    }
}
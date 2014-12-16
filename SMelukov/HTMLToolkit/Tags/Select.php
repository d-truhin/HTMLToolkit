<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 16.12.14
 * Time: 2:47
 */

namespace SMelukov\HTMLToolkit\Tags;

use SMelukov\HTMLToolkit\HTMLTag;


/**
 * Simple "select" tag realization
 */
class Select extends HTMLTag
{
    public function __construct()
    {
        parent::__construct('select', [], false);
    }

    /**
     * Get selected options
     *
     * @return Option[]
     */
    function getSelected()
    {
        $res = [];
        foreach ($this->getOptions() as $option) {
            if ($option->selected())
                $res[] = $option;
        }
        return $res;
    }

    /**
     * Get list of all options of the select
     *
     * @return Option[]
     */
    function getOptions()
    {
        $res = [];
        foreach ($this->getChildrenList() as $option) {
            if ($option instanceof Option)
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
        $this->append($option);
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
        $this->removeChildren($option);
        return $this;
    }
}
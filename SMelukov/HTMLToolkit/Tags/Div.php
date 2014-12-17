<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 16.12.14
 * Time: 2:47
 */

namespace SMelukov\HTMLToolkit\Tags;

use SMelukov\HTMLToolkit\HTMLTag;
use SMelukov\HTMLToolkit\NodeGroup;
use SMelukov\HTMLToolkit\TextNode;


/**
 * Simple "select" tag realization
 */
class Div extends HTMLTag
{
    public function __construct($content)
    {
        if (is_scalar($content))
            $content = new TextNode($content);
        parent::__construct('div', [], false);
        $this->append($content);
    }

    /**
     * Get selected options
     *
     * @return NodeGroup
     */
    function getSelected()
    {
        $res = [];
        foreach ($this->getOptions() as $option) {
            if ($option->selected())
                $res[] = $option;
        }
        return new NodeGroup('selected', $res);
    }

    /**
     * Get list of all options of the select
     *
     * @return NodeGroup
     */
    function getOptions()
    {
        $res = [];
        foreach ($this->getChildrenList() as $option) {
            if ($option instanceof Option)
                $res[] = $option;
        }
        return new NodeGroup('options', $res);
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
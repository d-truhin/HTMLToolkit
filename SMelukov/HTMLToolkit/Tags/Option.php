<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 16.12.14
 * Time: 2:48
 */

namespace SMelukov\HTMLToolkit\Tags;

use SMelukov\HTMLToolkit\HTMLTag;

/**
 * Simple "option" tag realization
 */
class Option extends HTMLTag
{
    public function __construct($value = '', $text = '')
    {
        parent::__construct('option', [], false);
        $this->set('value', $value)->setText($text);
    }

    /**
     * Get value of option
     *
     * @return string
     */
    function value()
    {
        return $this->get('value');
    }

    /**
     * Is this option selected?
     *
     * @return string
     */
    function selected()
    {
        return $this->get('selected');
    }

    /**
     * Set the option as selected
     *
     * @param $isSelected
     * @return $this
     */
    function setSelected($isSelected)
    {
        if (!$isSelected)
            $this->unsetAttr('selected');
        else
            $this->getAttr('selected')->append('selected');
        return $this;
    }
}
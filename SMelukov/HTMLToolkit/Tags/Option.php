<?php
/**
 * Created by PhpStorm.
 * User: smelukov
 * Date: 16.12.14
 * Time: 2:48
 */
use SMelukov\HTMLToolkit\HTMLTag;

/**
 * Simple "option" tag realization
 */
class Option extends HTMLTag
{
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
}
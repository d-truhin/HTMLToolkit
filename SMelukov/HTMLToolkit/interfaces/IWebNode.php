<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 20:54
 */

namespace SMelukov\HTMLToolkit\interfaces;
use SMelukov\HTMLToolkit\interfaces;


abstract class IWebNode extends interfaces\IElement
{
    public function __toString()
    {
        return $this->getText();
    }

    abstract public function outStart($onlyReturn = false);
    abstract public function out($onlyReturn = false);
    abstract public function outEnd($onlyReturn = false);
    abstract public function setText($text);
    abstract public function getText();
}
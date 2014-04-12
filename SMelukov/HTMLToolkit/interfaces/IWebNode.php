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

    public function outStart($onlyReturn = false)
    {
        return $onlyReturn ? '' : $this;
    }
    abstract public function out($onlyReturn = false);
    public function outEnd($onlyReturn = false)
    {
        return $onlyReturn ? '' : $this;
    }
    abstract public function setText($text);
    abstract public function getText();
    abstract public function setHTML($html);
    abstract public function getHTML();
}
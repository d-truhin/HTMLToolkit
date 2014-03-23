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
    protected function encodeContent($content, $flags = false)
    {
        if($flags == false)
            $flags = ENT_QUOTES | ENT_HTML401 | ENT_DISALLOWED | ENT_SUBSTITUTE;

        return htmlspecialchars($content, $flags);
    }

    abstract public function outStart($onlyReturn = false);
    abstract public function out($onlyReturn = false);
    abstract public function outEnd($onlyReturn = false);
}
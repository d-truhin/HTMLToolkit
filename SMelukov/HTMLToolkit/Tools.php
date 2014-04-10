<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 10.04.14
 * Time: 21:22
 */

namespace SMelukov\HTMLToolkit;


class Tools
{
    static public function encode($content, $flags = false)
    {
        if($flags == false)
            $flags = ENT_QUOTES | ENT_HTML401 | ENT_DISALLOWED | ENT_SUBSTITUTE;

        return htmlspecialchars($content, $flags);
    }
} 
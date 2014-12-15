<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 10.04.14
 * Time: 21:22
 */

namespace SMelukov\HTMLToolkit;


/**
 * Some useful tools
 *
 * @package SMelukov\HTMLToolkit
 */
class Tools
{
    /**
     * Encode HTML entities
     *
     * @param $content
     * @param bool $flags
     * @return string
     */
    static public function encode($content, $flags = false)
    {
        if ($flags == false)
            $flags = ENT_QUOTES | ENT_HTML401 | ENT_DISALLOWED | ENT_SUBSTITUTE;

        return htmlspecialchars($content, $flags);
    }

    /**
     * Decode HTML entities
     *
     * @param $content
     * @param bool $flags
     * @return string
     */
    static public function decode($content, $flags = false)
    {
        if ($flags == false)
            $flags = ENT_QUOTES | ENT_HTML401;

        return html_entity_decode($content, $flags);
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 20:54
 */

namespace SMelukov\HTMLToolkit;


abstract class IWebNode
{
    use IContainable;

    static $_next_id = 0;

    protected $_id = 0;

    public function __construct()
    {
        $this->_id = self::$_next_id++;
    }

    public function getID()
    {
        return $this->_id;
    }

    protected function encodeContent($content, $flags = false)
    {
        if($flags == false)
            $flags = ENT_QUOTES | ENT_HTML401 | ENT_DISALLOWED | ENT_SUBSTITUTE;

        return htmlspecialchars($content, $flags);
    }

    abstract public function outStart($onlyReturn = false);
    public function out($onlyReturn = false)
    {
        ob_start();
        $this->outStart();
        /** @var IWebNode $children */
        foreach($this->getChildrenList() as $children)
        {
            $children->out($onlyReturn);
        }
        $this->outEnd();
        if($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }
    abstract public function outEnd($onlyReturn = false);
}
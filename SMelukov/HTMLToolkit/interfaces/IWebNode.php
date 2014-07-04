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

    function __clone()
    {
        $this->_id = $this->UID();
        $this->remove();
        $children = $this->getChildrenList();
        $this->removeAllChildren();
        if($children)
            foreach($children as $childrenItem)
                $this->append(clone $childrenItem);
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

    public final function parseStart()
    {
        ob_start();
        return $this;
    }
    public final function parserGetData()
    {
        if(ob_get_level())
        {
            $parserResult = ob_get_contents();
            $this->parseProcess($parserResult);
            ob_clean();
        }
        return $this;
    }
    public final function parseEnd()
    {
        $this->parserGetData();
        if(ob_get_level())
            ob_end_clean();
        return $this;
    }

    abstract protected function parseProcess($source);
}
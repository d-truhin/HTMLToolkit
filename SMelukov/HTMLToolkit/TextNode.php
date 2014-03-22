<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:28
 */

namespace SMelukov\HTMLToolkit;


class TextNode extends IWebNode
{
    protected $_content = '';

    public function outStart($onlyReturn = false) {}

    public function out($onlyReturn = false)
    {
        if($onlyReturn)
            return $this->encodeContent($this->_content);
        echo $this->encodeContent($this->_content);
        return $this;
    }

    public function outEnd($onlyReturn = false) {}

    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }
}
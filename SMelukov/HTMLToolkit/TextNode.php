<?php
namespace SMelukov\HTMLToolkit;
use SMelukov\HTMLToolkit\interfaces;

/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:28
 *
 * @method HTMLTag parent();
 */
class TextNode extends interfaces\IWebNode
{
    protected $_content = '';

    function __toString()
    {
        return $this->_content;
    }

    public function __construct($content = '')
    {
        parent::__construct();
        $this->_content = $content;
    }

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

    /**
     * @param interfaces\IElement $what
     * @return $this
     */
    public function append(interfaces\IElement $what)
    {
        $this->_content.= $what;
        return $this;
    }

    /**
     * @param interfaces\IElement $what
     * @return $this
     */
    public function prepend(interfaces\IElement $what)
    {
        $this->_content = $what.$this->_content;
        return $this;
    }
}
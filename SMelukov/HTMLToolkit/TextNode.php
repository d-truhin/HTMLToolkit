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
    protected $_text = '';

    public function __construct($content = '')
    {
        parent::__construct();
        $this->_text = $content;
    }

    public function outStart($onlyReturn = false) {}

    public function out($onlyReturn = false)
    {
        if($onlyReturn)
            return Tools::encode($this->_text);
        echo Tools::encode($this->_text);
        return $this;
    }

    public function outEnd($onlyReturn = false) {}

    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->_text;
    }

    /**
     * @param interfaces\IElement $what
     * @return $this
     */
    public function append(interfaces\IElement $what)
    {
        $this->_text.= $what;
        return $this;
    }

    /**
     * @param interfaces\IElement $what
     * @return $this
     */
    public function prepend(interfaces\IElement $what)
    {
        $this->_text = $what.$this->_text;
        return $this;
    }
}
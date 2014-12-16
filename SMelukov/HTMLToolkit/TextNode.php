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
    /**
     * @var string
     */
    protected $_text = '';

    /** {@inheritdoc} */
    public function __construct($text = '')
    {
        parent::__construct();
        $this->setText($text);
    }

    /** {@inheritdoc} */
    public function out($onlyReturn = false)
    {
        if ($onlyReturn)
            return $this->getText();
        echo $this->getText();
        return $this;
    }

    /** {@inheritdoc} */
    public function getText()
    {
        return Tools::encode($this->_text);
    }

    /** {@inheritdoc} */
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }

    /** {@inheritdoc} */
    public function append(interfaces\IElement $what, $clone = false)
    {
        $this->_text .= $what;
        return $this;
    }

    /** {@inheritdoc} */
    public function prepend(interfaces\IElement $what, $clone = false)
    {
        $this->_text = $what . $this->_text;
        return $this;
    }

    /** {@inheritdoc} */
    public function getHTML()
    {
        $this->_text;
    }

    /** {@inheritdoc} */
    function getType()
    {
        // TODO: Implement getType() method.
    }

    /** {@inheritdoc} */
    protected function parseProcess($source)
    {
        $this->setHTML($source);
    }

    /** {@inheritdoc} */
    public function setHTML($html)
    {
        $this->setText(strip_tags($html));
    }
}
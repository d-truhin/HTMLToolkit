<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 20:54
 */

namespace SMelukov\HTMLToolkit\Interfaces;

use SMelukov\HTMLToolkit\Interfaces;


/**
 * Base class which implements a web node behavior
 *
 * @package SMelukov\HTMLToolkit\Interfaces
 */
abstract class IWebNode extends Interfaces\IElement
{
    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getText();
    }

    /**
     * Get node content as text
     *
     * @return mixed
     */
    abstract public function getText();

    /**
     *
     */
    function __clone()
    {
        $this->remove();
        $children = $this->getChildrenList();
        $this->removeAllChildren();
        if ($children)
            foreach ($children as $childrenItem)
                $this->append(clone $childrenItem);
    }

    /**
     * Output open part of node
     *
     * @param bool $onlyReturn return as a string or not
     * @return IWebNode|string
     */
    public function outStart($onlyReturn = false)
    {
        return $onlyReturn ? '' : $this;
    }

    /**
     * Output node content with open & close parts
     *
     * @param bool $onlyReturn
     * @return mixed
     */
    abstract public function out($onlyReturn = false);

    /**
     * Output close part of node
     *
     * @param bool $onlyReturn return as a string or not
     * @return IWebNode|string
     */
    public function outEnd($onlyReturn = false)
    {
        return $onlyReturn ? '' : $this;
    }

    /**
     * Set text for node
     *
     * @param $text
     * @return mixed
     */
    abstract public function setText($text);

    /**
     * Set html for node
     *
     * @param $html
     * @return mixed
     */
    abstract public function setHTML($html);

    /**
     * Get node content as HTML
     *
     * @return mixed
     */
    abstract public function getHTML();

    /**
     * Start parsing process for the node
     *
     * @return $this
     */
    public final function parseStart()
    {
        ob_start();
        return $this;
    }

    /**
     * End parsing process for the node
     *
     * @return $this
     */
    public final function parseEnd()
    {
        $this->parserGetData();
        if (ob_get_level())
            ob_end_clean();
        return $this;
    }

    /**
     * Get result of the parsing process
     *
     * @return $this
     */
    public final function parserGetData()
    {
        if (ob_get_level()) {
            $parserResult = ob_get_contents();
            $this->parseProcess($parserResult);
            ob_clean();
        }
        return $this;
    }

    /**
     * Implementation of parsing logic for concrete node type
     *
     * @param $source
     * @return mixed
     */
    abstract protected function parseProcess($source);

    /**
     * Get type of the node
     *
     * @return mixed
     */
    abstract function getType();
}
<?php
namespace SMelukov\HTMLToolkit;

use SMelukov\HTMLToolkit\Interfaces;
use SMelukov\HTMLToolkit\Tools\HTMLParser;

/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:12
 *
 * @method HTMLTag parent();
 * @method interfaces\IWebNode[] getChildrenList($idInKeys = false);
 */
class HTMLTag extends Interfaces\IWebNode
{
    /**
     * @var string
     */
    protected $_type = '';
    /**
     * @var bool
     */
    protected $_single = false;
    /**
     * @var TagAttribute[]
     */
    protected $_attributes = [];


    /** {@inheritdoc} */
    public function __construct($type, $attributes = [], $single = false)
    {
        parent::__construct();
        $this->_type = $type;
        foreach (is_array($attributes) ? $attributes : [] as $attrName => $attrValue)
            $this->set($attrName, $attrValue);
        $this->_single = $single;
    }

    /**
     * Set attribute value
     *
     * @param $name
     * @param string $value
     * @return $this
     */
    public function set($name, $value = '')
    {
        if (isset($this->_attributes[$name])) {
            $this->_attributes[$name]->clear();
            $this->_attributes[$name]->append($value);
        } else
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::DEFAULT_DELIMITER, (is_array($value) ? $value : [$value]));

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Get attribute object
     *
     * @param string $name
     * @return TagAttribute
     */
    public function getAttr($name)
    {
        if (isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        else
            return ($this->_attributes[$name] = new TagAttribute($name));
    }

    /**
     * Get attribute value
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function get($name, $default = '')
    {
        if (!isset($this->_attributes[$name]))
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::DEFAULT_DELIMITER, [$default]);

        return $this->_attributes[$name]->format();
    }

    /**
     * Add some value to attribute value set. Delimiter of attribute value sets separately.
     *
     * For example class="cl1 cl2"
     *
     * $tag->addToAttr('class', 'cl3')
     *
     * $tag->get('class') //cl1 cl2 cl3
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function addToAttr($name, $value)
    {
        if (!isset($this->_attributes[$name]))
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::DEFAULT_DELIMITER, (is_array($value) ? $value : [$value]));
        else
            $this->_attributes[$name]->append($value);

        return $this;
    }

    /**
     * Delele some value from attribute value set. Delimiter of attribute value sets separately.
     *
     * For example class="cl1 cl2 cl3"
     *
     * $tag->delFromAttr('class', 'cl2')
     *
     * $tag->get('class') //cl1 cl3
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function delFromAttr($name, $value)
    {
        if (isset($this->_attributes[$name]))
            $this->_attributes[$name]->unsetValue($value);

        return $this;
    }

    /**
     * Remove concrete attribute
     *
     * @param $name
     * @return $this
     */
    public function unsetAttr($name)
    {
        $_temp = is_array($name) ? $name : [$name];
        foreach ($_temp as $attrName)
            unset($this->_attributes[$attrName]);

        return $this;
    }

    /**
     * Remove all attributes of tag
     *
     * @return $this
     */
    public function unsetAttrAll()
    {
        $this->_attributes = [];
        return $this;
    }

    /** {@inheritdoc} */
    public function setText($text)
    {
        $this->removeAllChildren();
        $this->append(new TextNode($text));

        return $this;
    }

    /** {@inheritdoc} */
    public function getText()
    {
        return strip_tags($this->out(true));
    }

    /** {@inheritdoc} */
    public function out($onlyReturn = false)
    {
        ob_start();
        $this->outStart();
        $this->outChildren();
        $this->outEnd();
        if ($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    /** {@inheritdoc} */
    public function outStart($onlyReturn = false)
    {
        ob_start();
        echo "<{$this->_type}";
        /** @var TagAttribute $attrValue */
        foreach ($this->getAttrList() as $attrName => $attrValue) {
            echo " $attrName=\"{$attrValue->format()}\"";
        }
        if ($this->_single)
            echo '/';
        echo '>';
        if ($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    /**
     * @return TagAttribute[]
     */
    public function getAttrList()
    {
        return $this->_attributes;
    }

    /**
     * Output all children of the tag
     *
     * @param bool $onlyReturn return as a string or not
     * @return $this|string
     */
    public function outChildren($onlyReturn = false)
    {
        ob_start();
        /** @var interfaces\IWebNode $children */
        foreach ($this->getChildrenList() as $children) {
            $children->out(false);
        }
        if ($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    /** {@inheritdoc} */
    public function outEnd($onlyReturn = false)
    {
        ob_start();
        if (!$this->_single)
            echo "</{$this->_type}>";
        if ($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    /** {@inheritdoc} */
    public function setHTML($html, $rewrite = true)
    {
        if ($rewrite)
            $this->removeAllChildren();
        $this->parseStart();
        echo $html;
        $this->parseEnd();
        return $this;
    }

    /** {@inheritdoc} */
    public function getHTML()
    {
        return $this->out(true);
    }

    /** {@inheritdoc} */
    protected function parseProcess($source)
    {
        foreach (HTMLParser::parse($source)->getElementsList() as $element)
            $this->append($element);
        return $this;
    }
}
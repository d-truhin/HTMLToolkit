<?php
namespace SMelukov\HTMLToolkit;
use SMelukov\HTMLToolkit\interfaces;

/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:12
 *
 * @method HTMLTag parent();
 * @method interfaces\IWebNode getChildrenList();
 */
class HTMLTag extends interfaces\IWebNode
{
    protected $_type        = '';
    protected $_single      = false;
    /**
     * @var TagAttribute[]
     */
    protected $_attributes  = [];

    function __toString()
    {
        return strip_tags($this->out(true));
    }

    public function __construct($type, $attributes = array(), $single = false)
    {
        parent::__construct();
        $this->_type = $type;
        foreach(is_array($attributes) ? $attributes : [] as $attrName=>$attrValue)
            $this->set($attrName, $attrValue);
        $this->_attributes;
        $this->_single = $single;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function outStart($onlyReturn = false)
    {
        ob_start();
        echo "<{$this->_type}";
        /** @var TagAttribute $attrValue */
        foreach($this->getAttrList() as $attrName => $attrValue)
        {
            echo " $attrName=\"{$attrValue->format()}\"";
        }
        if($this->_single)
            echo '/';
        echo '>';
        if($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    public function outChildrens($onlyReturn = false)
    {
        ob_start();
        /** @var interfaces\IWebNode $children */
        foreach($this->getChildrenList() as $children)
        {
            $children->out(false);
        }
        if($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    public function out($onlyReturn = false)
    {
        ob_start();
        $this->outStart();
        $this->outChildrens();
        $this->outEnd();
        if($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    public function outEnd($onlyReturn = false)
    {
        ob_start();
        if(!$this->_single)
            echo "</{$this->_type}>";
        if($onlyReturn)
            return ob_get_clean();
        ob_end_flush();
        return $this;
    }

    /**
     * @param string $name
     * @return TagAttribute
     */
    public function getAttr($name)
    {
        if(isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        else
            return ($this->_attributes[$name] = new TagAttribute($name));
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function get($name, $default = '')
    {
        if(!isset($this->_attributes[$name]))
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::$default_delimiter, [$default]);

        return $this->_attributes[$name]->format();
    }

    public function set($name, $value = '')
    {
        if(isset($this->_attributes[$name]))
        {
            $this->_attributes[$name]->clear();
            $this->_attributes[$name]->append($value);
        }
        else
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::$default_delimiter, (is_array($value) ? $value : [$value]));

        return $this;
    }

    public function addToAttr($name, $value)
    {
        if(!isset($this->_attributes[$name]))
            $this->_attributes[$name] = new TagAttribute($name, TagAttribute::$default_delimiter, (is_array($value) ? $value : [$value]));
        else
            $this->_attributes[$name]->append($value);

        return $this;
    }

    public function delFromAttr($name, $value)
    {
        if(isset($this->_attributes[$name]))
            $this->_attributes[$name]->unsetValue($value);

        return $this;
    }

    public function unsetAttr($name)
    {
        $_temp = is_array($name) ? $name : [$name];
        foreach($_temp as $attrName)
            unset($this->_attributes[$attrName]);

        return $this;
    }

    public function unsetAttrAll()
    {
        $this->_attributes = [];
        return $this;
    }

    /**
     * @return TagAttribute[]
     */
    public function getAttrList()
    {
        return $this->_attributes;
    }
}
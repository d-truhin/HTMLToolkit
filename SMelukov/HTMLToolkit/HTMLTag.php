<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:12
 */

namespace SMelukov\HTMLToolkit;


class HTMLTag extends IWebNode
{
    protected $_type        = '';
    protected $_single      = false;
    protected $_attributes  = [];

    public function __construct($type, $attributes = array(), $single = false)
    {
        $this->_type = $type;
        $this->_attributes = is_array($attributes) ? $attributes : [];
        $this->_single = $single;
    }

    public function outStart($onlyReturn = false)
    {
        ob_start();
        echo "<{$this->_type}";
        foreach($this->getAttrList() as $attrName => $attrValue)
        {
            echo " $attrName=\"{$this->encodeAttr($attrName)}\"";
        }
        if($this->_single)
            echo '/';
        echo '>';
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

    public function get($name, $default = '')
    {
        if(isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        else
            return $default;
    }

    public function set($name, $value = '')
    {
        $this->_attributes[$name] = $value;
        return $this;
    }

    public function unsetAttr($name)
    {
        if(!is_array($name))
            $name = [$name];

        foreach($name as $attrName => $attrValue)
            unset($this->_attributes[$attrName]);

        return $this;
    }

    protected function encodeAttr($name, $flags = false)
    {
        if(isset($this->_attributes[$name]))
        {
            if($flags == false)
                $flags = ENT_COMPAT | ENT_HTML401 | ENT_DISALLOWED | ENT_SUBSTITUTE;

            return htmlspecialchars($this->_attributes[$name], $flags);
        }
        return '';
    }

    public function getAttrList()
    {
        return $this->_attributes;
    }

    public function unsetAttrAll()
    {
        $this->_attributes = [];
        return $this;
    }
}
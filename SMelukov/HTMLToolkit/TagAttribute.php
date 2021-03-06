<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 23.03.14
 * Time: 22:20
 */

namespace SMelukov\HTMLToolkit;


use SMelukov\HTMLToolkit\Interfaces\IHasID;
use SMelukov\HTMLToolkit\Traits\HasID;

class TagAttribute implements IHasID
{
    use HasID;
    const       DEFAULT_DELIMITER = ' ';
    protected $_name      = '';
    protected $_values    = [];
    protected $_delimiter = self::DEFAULT_DELIMITER;

    public function __construct($name, $delimiter = self::DEFAULT_DELIMITER, $values = [])
    {
        $this->_name      = $name;
        $this->_delimiter = $delimiter;
        $this->append(is_array($values) ? $values : explode($delimiter, $values));
    }

    public function append($value)
    {
        foreach (is_array($value) ? $value : [$value] as $val) {
            foreach (explode($this->_delimiter, $val) as $el)
                array_push($this->_values, $el);
        }
        return $this;
    }

    public function getDelimiter()
    {
        return $this->_delimiter;
    }

    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;
        if (!empty($this->_values)) {
            $newValues = [];
            foreach ($this->_values as $val)
                $newValues += explode($delimiter, $val);
            $this->_values = $newValues;
        }
        return $this;
    }

    public function getValues()
    {
        return $this->_values;
    }

    public function prepend($value)
    {
        foreach (is_array($value) ? $value : [$value] as $val) {
            foreach (explode($this->_delimiter, $val) as $el)
                array_unshift($this->_values, $el);
        }
        return $this;
    }

    public function unsetValue($value)
    {
        $_temp = is_array($value) ? $value : [$value];
        $this->_values = array_diff($this->_values, $_temp);
        return $this;
    }

    public function clear()
    {
        $this->_values = [];
        return $this;
    }

    public function switchValue($from, $to, $ignoreCase = false)
    {
        $cmpFunc = $ignoreCase ? "strcasecmp" : "strcmp";
        foreach ($this->_values as &$val) {
            if (!$cmpFunc($val, $from))
                $val = $to;
        }
        unset($val);

        return $this;
    }

    public function format($encode = true)
    {
        $_temp = implode($this->_delimiter, $this->_values);
        if ($encode)
            $_temp = Tools::encode($_temp);

        return $_temp;
    }
} 
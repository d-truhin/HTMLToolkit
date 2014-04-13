<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 10:56
 */

namespace SMelukov\HTMLToolkit;


use SMelukov\HTMLToolkit\interfaces\IGroup;

/**
 * @method HTMLTag[] getElementsList($idInKeys = false);
 * @method HTMLTag each($callback = null);
 */
class NodeGroup extends IGroup
{

    /**
     * @param $name
     * @return TagAttribute
     */
    public function getAttr($name)
    {
        $attrGroup = new AttributeGroup($name);
        /** @var $element HTMLTag */
        foreach($this->_elements as $element)
            $attrGroup->addElements($element->getAttr($name));
        return $attrGroup;
    }
}
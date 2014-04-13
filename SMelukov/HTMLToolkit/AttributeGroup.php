<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 13.04.14
 * Time: 19:25
 */

namespace SMelukov\HTMLToolkit;

use SMelukov\HTMLToolkit\interfaces\IGroup;
use SMelukov\HTMLToolkit\TagAttribute;

/**
 * @method TagAttribute[] getElementsList($idInKeys = false);
 * @method TagAttribute each($callback = null);
 */
class AttributeGroup extends IGroup
{}
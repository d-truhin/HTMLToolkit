<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:26
 */

use SMelukov\HTMLToolkit\HTMLTag;
use SMelukov\HTMLToolkit\TextNode;

require_once "smelukov_autoload.php";

$text = new TextNode();
$text->append(new TextNode('привет'));
$i = new HTMLTag('i');
$i->append(new TextNode(' еще привет<div>123</div>'));
$b = new HTMLTag('b');
$b->set('class', 'some_class')->append($text)->append($i)->addToAttr('class', 'more_class')->clearAttr('class');
$text->remove();
$b->out();
?><pre><?
print_r($b);?>
</pre>
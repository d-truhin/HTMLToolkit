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
$i->append(new TextNode(' еще привет<div>123</div>&lt &lt;'));
$b = new HTMLTag('b');
$b->set('class', 'some_class')->append($text)->append($i)->addToAttr('class', 'more_class')->delFromAttr('class', 'some_class');
$text->remove();
$b->getAttr('rel')->setDelimiter(',')->append('1,2,3')->unsetValue(2)->switchValue('3','7');
$b->out();

$select = (new HTMLTag('select'))->set('name', 'some_name');
for($i = 0; $i<5; $i++)
    $select->append((new HTMLTag('option'))->set('value', $i)->append(new TextNode("Option $i")));
$select->getChildrenList()[6]->append(new TextNode('added'))->parent()->addToAttr('class', 'select_class');
$select->outStart();
(new HTMLTag('option', array('value'=>array('777', '888'))))->append(new TextNode('ALL'))->out();
$select->outChildrens();
$select->outEnd();
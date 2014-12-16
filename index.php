<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:26
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

use SMelukov\HTMLToolkit\HTMLTag;
use SMelukov\HTMLToolkit\NodeGroup;
use SMelukov\HTMLToolkit\Tags\Option;
use SMelukov\HTMLToolkit\Tags\Select;
use SMelukov\HTMLToolkit\TextNode;
use SMelukov\HTMLToolkit\Tools;
use SMelukov\HTMLToolkit\Tools\HTMLParser;

require_once "smelukov_autoload.php";

//simple tests
$text = new TextNode();
$text->append(new TextNode('привет'));
$i = new HTMLTag('i');
$i->append(new TextNode(' еще привет<div>123</div>&lt &lt;'));

//attributes tests
$b = new HTMLTag('b');
$b->set('class', 'some_class')->append($text)->append($i)->addToAttr('class', 'more_class')->delFromAttr('class', 'some_class');
$text->remove();
$b->getAttr('rel')->setDelimiter(',')->append('1,2,3')->unsetValue(2)->switchValue('3', '7');
$b->out();

//working with children tests
$select = (new HTMLTag('select'))->set('name', 'some_name');
for ($i = 0; $i < 5; $i++)
    $select->append((new HTMLTag('option'))->set('value', $i)->append(new TextNode("Option $i")));
$select->getChildrenList()[1]->append(new TextNode('added'))->parent()->addToAttr('class', 'select_class');
$select->outStart();
(new HTMLTag('option', ['value' => ['777', '888']]))->append(new TextNode('ALL'))->out();
$select->outChildren();
$select->outEnd();
(new TextNode())->append(new TextNode('before '))->append((new HTMLTag('div'))->append(new TextNode('inner')))->append(new TextNode(' after'))->out();


//get text & html tests
$span = (new HTMLTag('span'))->append(new TextNode('1<2>3'));

echo $span;
echo $select->getHTML();
echo $select->getText();
$select->setText('text')->out();

//groups tests
$nodeGroup = (new NodeGroup('some_name', [
    new HTMLTag('div'),
    new HTMLTag('div'),
    (new HTMLTag('div'))->set('rel', '2 3')->setText('!!!'),
    new HTMLTag('div'),
    new HTMLTag('div')]))
    ->each(function ($element, $index) {
        /** @var $element HTMLTag */
        $element->setText($index)->getAttr('rel')->append('1')->switchValue(3, 4);
    });

$nodeGroup->getAttr('rel')->switchValue(4, 0)->switchValue(1, 2);

$nodeGroup->each()->out();

//more tests
$a = new HTMLTag('div');
$t1 = (new HTMLTag('div'))->setText('текст 1')->set('class', 'c1');
$t2 = (new HTMLTag('div'))->setText('текст 2')->set('class', 'c2');
$a->append($t1)->append($t2);
$b = (new HTMLTag('div'))->append($t1, false)->append($t2, false);
$b->getChildrenList()[0]->setText('текст 3')->set('class', 'c3');
$b->getChildrenList()[1]->setText('текст 4')->set('class', 'c4');

$a->out();
$b->out();
echo '<br>=============================<br>';

//parser tests
(new HTMLTag('div'))->setHTML("<div class=\"c1\">123<b>456</b>789</div><div>d1</div><div>d2</div><div>d3</div>")->out();
HTMLParser::parse("<div class=\"c1\">123<b>456</b>789</div><div>d1</div><div>d2</div><div>еще текст</div>")->set('rel', '111')->out();
/** @noinspection PhpUndefinedMethodInspection */
HTMLParser::parse("привет")->set('rel', '111')->out();

$tag = (new HTMLTag('div'))->set('class', 'global')->parseStart(); ?>
    <div class="c1">123
        <b>456</b>789
    </div>
    <div>d1</div>
    <div>d2</div>
    <div>d3</div><?
echo htmlentities($tag->parseEnd()->out(true));

//select tests
$select = new Select();
$select->set('multiple');
$select->addOption(new Option('some val', 'opt-1'));
$select->addOption((new Option('some val 2', 'opt-2'))->setSelected(true));
$select->addOption((new Option('some val 3', 'opt-3'))->setSelected(true));
$select->addOption(new Option('some val 4', 'opt-4'));

$select->out();
$s = (new NodeGroup('options', $select->getSelected()));
$s->each()->out();
echo Tools::encode($select->getSelected()[0]->out(1));
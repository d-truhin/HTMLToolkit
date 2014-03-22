<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 19.03.14
 * Time: 21:26
 */

require_once "smelukov_autoload.php";

$tag = new \SMelukov\HTMLToolkit\TextNode();
$tag->setContent('123');
$tag->out();
$tag2 = new \SMelukov\HTMLToolkit\HTMLTag('b');
$tag2->set('class', "\"'&nbsp;")->append((new \SMelukov\HTMLToolkit\TextNode())->setContent('<i>777</i>'))->out();
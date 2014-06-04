<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/smelukov_autoload.php';
use SMelukov\HTMLToolkit\Tools\String;
use SMelukov\HTMLToolkit\Tools;

class Context
{
    const IN_OPEN_TAG           = 100;
    const IN_OPEN_ATTR_NAME     = 101;
    const IN_OPEN_ATTR_VALUE    = 102;
    const IN_CONTENT            = 200;
    const IN_CLOSE_TAG          = 300;
    const IN_CLOSE_ATTR_NAME    = 301;
    const IN_CLOSE_ATTR_VALUE   = 302;

    public $content = '';
    public $start   = -1;
    public $end     = -1;
    public $type;
}

$html = new String("-1<div>123<b>4&lt;5&gt;6</b>789</div>000");

$startCnt = new Context();
$startCnt->type = $startCnt::IN_CONTENT;
$startCnt->start = 0;
$context = [$startCnt];

foreach($html as $key=>$char)
{
    /** @var Context $currentCnt */
    /** @var Context $cnt */
    $currentCnt = $context[count($context)-1];
    //echo $char;
    switch($char)
    {
        case "<":
            switch($currentCnt->type)
            {
                case Context::IN_CONTENT:
                    $currentCnt->end = $key;
                    break;
            }
            $cnt = new Context();
            $cnt->start = $key;
            $cnt->type = $cnt::IN_OPEN_TAG;
            $context[]=$cnt;
            break;
        case ">":
            switch($currentCnt->type)
            {
                case Context::IN_OPEN_TAG:
                case Context::IN_CLOSE_TAG:
                    $currentCnt->end = $key;
                    break;
            }
            break;
        case "/":
            switch($currentCnt->type)
            {
                case Context::IN_OPEN_TAG:
                    $currentCnt->type = $cnt::IN_CLOSE_TAG;
                    break;
                case Context::IN_CONTENT:
                    $currentCnt->content.=$char;
                    break;
            }
            break;
        default:
            if(ord($char))
            {
                switch($currentCnt->type)
                {
                    case Context::IN_OPEN_TAG:
                    case Context::IN_CLOSE_TAG:
                        if($currentCnt->end>0)
                        {
                            $cnt = new Context();
                            $cnt->start = $key;
                            $cnt->type = $cnt::IN_CONTENT;
                            $context[]=$cnt;
                            $currentCnt = $cnt;
                        }
                        break;
                }
                $currentCnt->content.=$char;
            }
            break;
    }
}
$currentCnt = $context[count($context)-1];
if($currentCnt->end <0)
    $currentCnt->end = strlen($html)-1;

$root = new \SMelukov\HTMLToolkit\HTMLTag("div");
/** @var \SMelukov\HTMLToolkit\HTMLTag $pointer */
$pointer = $root;
/** @var $cnt Context */
foreach($context as $cnt)
{
    switch($cnt->type)
    {
        case Context::IN_OPEN_TAG:
            $tag = new \SMelukov\HTMLToolkit\HTMLTag($cnt->content);
            $pointer->append($tag);
            $pointer = $tag;
            break;
        case Context::IN_CLOSE_TAG:
            $pointer = $pointer->parent();
            break;
        case Context::IN_CONTENT:
            $text = new \SMelukov\HTMLToolkit\TextNode(Tools::decode($cnt->content));
            $pointer->append($text);
            break;
    }
}

$root->out();
/*$ar = [];
$ar[]='a';
$ar[]='b';
$ar[]='c';
echo end($ar);*/?>
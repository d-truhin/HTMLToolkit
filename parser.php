<?php
require_once __DIR__ . '/smelukov_autoload.php';
use SMelukov\HTMLToolkit\Tools;
use SMelukov\HTMLToolkit\Tools\String;

class Context
{
    const IN_OPEN_TAG         = 100;
    const IN_OPEN_ATTR_NAME   = 101;
    const IN_OPEN_ATTR_VALUE  = 102;
    const IN_CONTENT          = 200;
    const IN_CLOSE_TAG        = 300;
    const IN_CLOSE_ATTR_NAME  = 301;
    const IN_CLOSE_ATTR_VALUE = 302;

    public $isAttrib = false;
    public $content  = '';
    public $attrib   = '';
    public $start    = -1;
    public $end      = -1;
    public $type;
}

$html = new String('<b class="more_class" rel="1,7"><i> еще привет&lt;div&gt;123&lt;/div&gt;&amp;lt &amp;lt;</i></b><select name="some_name" class="select_class"><option value="777 888">ALL</option><option value="0">Option 0</option><option value="1">Option 1added</option><option value="2">Option 2</option><option value="3">Option 3</option><option value="4">Option 4</option></select>before inner after1&lt;2&gt;3<select name="some_name" class="select_class"><option value="0">Option 0</option><option value="1">Option 1added</option><option value="2">Option 2</option><option value="3">Option 3</option><option value="4">Option 4</option></select>Option 0Option 1addedOption 2Option 3Option 4<select name="some_name" class="select_class">text</select><div rel="2">0</div><div rel="2">1</div><div rel="2 0 2">2</div><div rel="2">3</div><div rel="2">4</div>');

$startCnt       = new Context();
$startCnt->type = $startCnt::IN_CONTENT;
$startCnt->start = 0;
$context        = [$startCnt];

foreach ($html as $key => $char) {
    /** @var Context $currentCnt */
    /** @var Context $cnt */
    $currentCnt = $context[count($context) - 1];
    //echo $char;
    switch ($char) {
        case "<":
            switch ($currentCnt->type) {
                case Context::IN_CONTENT:
                    $currentCnt->end = $key;
                    break;
            }
            $cnt       = new Context();
            $cnt->start = $key;
            $cnt->type = $cnt::IN_OPEN_TAG;
            $context[] = $cnt;
            break;
        case ">":
            switch ($currentCnt->type) {
                case Context::IN_OPEN_TAG:
                case Context::IN_CLOSE_TAG:
                    $currentCnt->end = $key;
                    break;
            }
            break;
        case "/":
            switch ($currentCnt->type) {
                case Context::IN_OPEN_TAG:
                    $currentCnt->type = $cnt::IN_CLOSE_TAG;
                    break;
                case Context::IN_CONTENT:
                    $currentCnt->content .= $char;
                    break;
            }
            break;
        default:
            if (ord($char)) {
                switch ($currentCnt->type) {
                    case Context::IN_OPEN_TAG:
                    case Context::IN_CLOSE_TAG:
                    if ($currentCnt->end > 0) {
                        $cnt       = new Context();
                            $cnt->start = $key;
                        $cnt->type = $cnt::IN_CONTENT;
                        $context[] = $cnt;
                            $currentCnt = $cnt;
                    } elseif ($char === ' ' && !$currentCnt->isAttrib) {
                            $currentCnt->isAttrib = true;
                        }
                        break;
                }
                if ($currentCnt->isAttrib)
                    $currentCnt->attrib .= $char;
                else
                    $currentCnt->content .= $char;
            }
            break;
    }
}
$currentCnt = $context[count($context) - 1];
if ($currentCnt->end < 0)
    $currentCnt->end = strlen($html) - 1;

$root = new \SMelukov\HTMLToolkit\HTMLTag("div");
/** @var \SMelukov\HTMLToolkit\HTMLTag $pointer */
$pointer = $root;
/** @var $cnt Context */
foreach ($context as $cnt) {
    switch ($cnt->type) {
        case Context::IN_OPEN_TAG:
            $tag      = new \SMelukov\HTMLToolkit\HTMLTag($cnt->content);
            $cnt->attrib = trim($cnt->attrib);
            preg_match_all('|(\w+\s*=\s*([\'\"]).*?\2)|', $cnt->attrib, $attribs);
            if (isset($attribs) && is_array($attribs) && count($attribs) > 1) {
                array_pop($attribs);
                array_shift($attribs);
            }

            foreach ($attribs[0] as $attr) {
                list($aName, $aVal) = explode('=', $attr);
                $aName = trim($aName);
                $aVal = trim($aVal);
                if ($aVal[0] == '\'' || $aVal[0] == '"')
                    $aVal = str_replace($aVal[0], '', $aVal);
                $tag->set($aName, $aVal);
            }
            $cnt->attrib = trim(preg_replace('|\s+|', ' ', preg_replace('|\w+\s*=\s*([\'\"]).*?\1|', ' ', $cnt->attrib)));
            $exploded = explode(' ', $cnt->attrib);
            if (is_array($exploded) && $exploded) {
                foreach ($exploded as $attr) {
                    if ($attr)
                        $tag->set(trim($attr), '');
                }
            }

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
echo end($ar);*/
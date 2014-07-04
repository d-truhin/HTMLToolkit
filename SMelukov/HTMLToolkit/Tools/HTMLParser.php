<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 05.07.14
 * Time: 0:31
 */

namespace SMelukov\HTMLToolkit\Tools;

use DOMDocument;
use DOMElement;
use SMelukov\HTMLToolkit\HTMLTag;
use SMelukov\HTMLToolkit\NodeGroup;
use SMelukov\HTMLToolkit\TextNode;

class HTMLParser
{
    public static $encoding = "UTF-8";
    protected function __construct(){}

    /**
     * @param string $html
     * @return NodeGroup
     */
    public static function parse($html)
    {
        libxml_use_internal_errors(true);
        $domDoc = new DOMDocument();
        $tag = new HTMLTag('div');
        $encPrefix = preg_match("/<\?xml[\s\S]+?encoding[\s\S]*?=[\s\S]*?[\"\']?[^\'\"\>]+[\'\"]?>/" , $html)?'':'<?xml encoding="'.self::$encoding.'">';
        if(@$domDoc->loadHTML($encPrefix.$html))
        {
            $self = new self;
            $self->recParse($domDoc->documentElement, $tag);
            if(count($tag->getChildrenList()) && $tag->getChildrenList()[0]->getType()==='body')
                $tag = $tag->getChildrenList()[0];
        }
        else
            libxml_clear_errors();
        $nodeGroup = new NodeGroup('parsed', $tag->getChildrenList());
        $tag->removeAllChildren();
        return $nodeGroup;
    }

    public static function parseStart()
    {
        ob_start();
    }

    /**
     * @return NodeGroup
     */
    public static function parseEnd()
    {
        $parserResult = '';
        if(ob_get_level())
            $parserResult = ob_get_clean();

        return self::parse($parserResult);
    }

    /**
     * @param DOMElement $domRoot
     * @param HTMLTag $parentTag
     */
    public function recParse(DOMElement $domRoot, HTMLTag $parentTag)
    {
        /** @var $cn DOMElement */
        foreach($domRoot->childNodes as $cn)
        {
            switch($cn->nodeType)
            {
                case XML_TEXT_NODE:
                    $parentTag->append(new TextNode($cn->textContent));
                    break;
                case XML_ELEMENT_NODE:
                    $newTag = new HTMLTag($cn->tagName);
                    if ($cn->hasAttributes())
                    {
                        foreach ($cn->attributes as $attr)
                            $newTag->set($attr->nodeName, $attr->nodeValue);
                    }

                    if($cn->hasChildNodes())
                        $this->recParse($cn, $newTag);

                    $parentTag->append($newTag);
                    break;
            }
        }
    }
} 
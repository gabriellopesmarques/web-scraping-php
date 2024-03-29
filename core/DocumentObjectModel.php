<?php

namespace Core;

use Symfony\Component\CssSelector\CssSelectorConverter;

class DocumentObjectModel
{
    public $content;

    public function __construct($html)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $this->content = $dom;
    }

    public function querySelector($query)
    {
        $converter = new CssSelectorConverter();
        $xPathQuery = $converter->toXPath($query);

        $xpath = new \DOMXPath($this->content);
        return $xpath->query($xPathQuery);
    }

    public function getElementById($id)
    {
        return $this->content->getElementById($id);
    }

    public function getElementsByTagName($id)
    {
        return $this->content->getElementsByTagName($id);
    }

    public function getTitle()
    {
        $titles = $this->content->getElementsByTagName("title");
        if ($titles->length > 0) {
            foreach ($titles as $title) {
                return trim($title->textContent);
            }
        }
    }

    public function getMetas()
    {
        $rtn = [];

        $searchList = [
            "title",
            "description",
            "keywords",
            "author",
            "viewport",
            "robots",
            "application-name",
            "og:type",
            "og:title",
            "og:description",
            "og:image",
            "og:site_name",
            "og:locale",
            "og:url",
            "fb:app_id",
            "twitter:card",
            "twitter:site",
            "twitter:site:id",
            "twitter:creator",
            "twitter:creator:id",
            "twitter:description",
            "twitter:title",
            "twitter:image",
            "twitter:image:alt",
            "twitter:player",
            "twitter:player:width",
            "twitter:player:height",
            "twitter:player:stream",
            "twitter:app:name:iphone",
            "twitter:app:url:iphone",
            "twitter:app:name:ipad",
            "twitter:app:id:ipad",
            "twitter:app:url:ipad",
            "twitter:app:name:googleplay",
            "twitter:app:id:googleplay",
            "twitter:app:url:googleplay"
        ];

        $metas = $this->content->getElementsByTagName("meta");

        if (!$metas->length) {
            return null;
        }

        foreach ($metas as $meta) {
            if (
                empty($rtn[$meta->getAttribute('name')]) &&
                in_array($meta->getAttribute('name'), $searchList) 
            ) {
                $rtn[$meta->getAttribute('name')] = trim($meta->getAttribute('content'));
            }

            if (
                empty($rtn[$meta->getAttribute('property')]) &&
                in_array($meta->getAttribute('property'), $searchList)
            ) {
                $rtn[$meta->getAttribute('property')] = trim($meta->getAttribute('content'));
            }
        }

        return $rtn;
    }
}

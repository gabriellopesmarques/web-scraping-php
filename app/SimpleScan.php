<?php
namespace App;

use Core\Request;
use Core\DocumentObjectModel as DOM;

class SimpleScan 
{
    public static function url($url)
    {
        $content = Request::get($url);
        $dom = new DOM($content['response']);
        
        $scraping = [
            'url' => $url,
            'title' => $dom->getTitle(),
            'metas' => $dom->getMetas(),
            'hrefs' => [
                'count' => 0,
                'list' => [],
            ]
        ];
        
        $as = $dom->getElementsByTagName("a");
        // $as = $dom->querySelector('nav#menu ol a');
        foreach ($as as $a) {
            $href = $a->getAttribute('href');
            if (!empty($href)) {
                $scraping['hrefs']['list'][] = $href;
                $scraping['hrefs']['count'] = $scraping['hrefs']['count']+1;
            }
        }

        return $scraping;
    }
}
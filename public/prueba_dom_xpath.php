<?php
$errorSetting = libxml_use_internal_errors(TRUE);
$feed = new DOMDocument();
$feed->load('https://news.ycombinator.com/rss');
libxml_clear_errors();
libxml_use_internal_errors($errorSetting);

if (isset($feed->documentElement)) {
    $xpath = new DOMXPath($feed);
    $xpath->registerNamespace('atom', 'http://www.w3.org/2005/Atom');
    echo $xpath->evaluate('string(/atom:feed/atom:title)'), "\n";
    echo $xpath->evaluate('string(/atom:feed/atom:subtitle)'), "\n";
    echo str_repeat('*', 72), "\n\n";
    foreach ($xpath->evaluate('//atom:entry') as $entryNode) {
        echo $xpath->evaluate('string(atom:title)', $entryNode), "\n";
        if ($xpath->evaluate('count(atom:category) > 0', $entryNode)) {
            echo 'Categories: ';
            foreach ($xpath->evaluate('atom:category/@term', $entryNode) as $index => $categoryAttribute) {
                if ($index > 0) {
                    echo ', ';
                }
                echo $categoryAttribute->value;
            }
            echo "\n";
        }
        echo $xpath->evaluate(
            'string(atom:link[@rel="alternate" and @type="text/html"][1]/@href)',
            $entryNode
        ), "\n";
        echo "\n";
    }
} else {
    echo 'Invalid feed.';
}

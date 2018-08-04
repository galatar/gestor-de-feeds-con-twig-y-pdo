<html>
<head>
    <title>RSS Feed Reader</title>
</head>
<body>
<?php
//Feed URLs
$feeds = array(
        "http://feeds.feedburner.com/WebToolsWeekly",
);
$reserva = array(
    "http://galatar.com/feed/",
    "http://ellatidodelucifer.blogspot.com/atom.xml",
    "http://maxburstein.com/rss",
    "https://news.ycombinator.com/rss",
    "https://www.reddit.com/r/programming/.rss",
    "https://www.elblogsalmon.com/index.xml",
    "http://www.engadget.com/rss.xml",
    "http://www.reddit.com/r/programming/.rss",
);

//Read each feed's items
$entries = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    if ($xml->xpath("//item")) {
        $entries = array_merge($entries, $xml->xpath("//item"));
    } else {
        $xml->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
        $entries = array_merge($entries, $xml->xpath("//atom:entry"));
    }
}

//Sort feed entries by pubDate
usort($entries, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});

?>

<ul><?php
    //Print all the entries
    foreach ($entries as $entry) {
        ?>
        <li><?= strftime('%d/%m/%Y', strtotime($entry->pubDate)) ?> -
            <?= strftime('%d/%m/%Y', strtotime($entry->published)) ?> -
            <a href="<?= $entry->link ?>"><?= $entry->title ?></a>
            (<?= parse_url($entry->link)['host'] ?>)
        </li>
        <?php
    }
    ?>
</ul>
</body>
</html>
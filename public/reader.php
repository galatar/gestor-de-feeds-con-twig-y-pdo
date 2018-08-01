<html>
<head>
    <title>RSS Feed Reader</title>
</head>
<body>
<?php
//Feed URLs
$feeds = array(
    "http://galatar.com/feed/",
    "http://ellatidodelucifer.blogspot.com/feeds/posts/default",
    "https://www.reddit.com/r/programming/.rss"
);
$reserva = array(
    "https://www.elblogsalmon.com/index.xml",
    "http://maxburstein.com/rss",
    "http://www.engadget.com/rss.xml",
    "http://www.reddit.com/r/programming/.rss"
);

//Read each feed's items
$entries = array();
foreach ($feeds as $feed) {
    $xml = simplexml_load_file($feed);
    $entries = array_merge($entries, $xml->xpath("//item"));
    $entries = array_merge($entries, $xml->xpath("//entry"));
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
        <li><img src="<?= $entry->image->url ?>"><a href="<?= $entry->link ?>"><?= $entry->title ?></a> (<?= parse_url($entry->link)['host'] ?>)
            <p><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></p>
            <p><?= $entry->description ?></p></li>
        <?php
    }
    ?>
</ul>
</body>
</html>

<?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?> <a href="<?php echo $link; ?>">Read more</a>

<?php
require 'magpierss/rss_fetch.inc';

function age($t) {
    $age = time()-$t;
    $age /= 60;
    $h = $m = $d = 0;
    if ($age > 60) {
        $age = $h = round($age/60, 0);
        $m = $age % 60;
    }
    if ($age > 24) {
        $age = $d = round($age/24, 0);
        $h = $age % 24;
    }
    return ($d?$d.'d ':'').($h.'h ').$m.'m';
}

$f = file('feeds.txt');

$rss = array();

foreach ($f as $l) {
    $l = trim($l);
    $rss[] = fetch_rss($l);
}

?><html>
    <head>
        <style type='text/css'>
        .feed {
            border: 1px solid blue;
            float: left;
            margin: 1px;
            width: 300px;
        }
        a {
            font-size: 7pt;
            text-decoration: none;
        }
        a:hover {
            background-color: #DDD;
        }
        a.title {
            font-weight: bold;
        }
        </style>
    </head>
    <body>
<?php   foreach ($rss as $r): ?>
<div class='feed'>
<a class='title' href='<?= $r->link ?>'><?= $r->channel['title'] ?></a><br />
<?php   foreach ($r->items as $i): ?>
<?= isset($i['date_timestamp']) ? age($i['date_timestamp']).' ago<br />' : '' ?>
<a class='link' href='<?= $i['link']?>'><?= $i['title'] ?></a><br />
<?= $i['pubdate']; ?><hr />
<!--
<?= $i['description']; ?><hr />
<?= $i['summary']; ?>
-->
<?php   endforeach; ?>
</div>
<?php   endforeach; ?>
    </body>
</html>

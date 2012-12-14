<?php
require 'magpierss/rss_fetch.inc';

$maxlen = 60;
$maxage = 31*60*24;
$maxcount = 10;

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
    return 
        ($d ? $d.'d ' : '' ).
        ($h . 'h ').
        ($m . 'm' );
}

function plainage($t) {
    return (time()-$t)/60;
}

function ageToOpacity($t) {
    if (empty($t))
        return 1;

    $age = time() - $t;
    return 1-min(0.8, $age / 60 / 60 / 24);
}

$f = file('feeds.txt');

$rss = array();

foreach ($f as $l) {
    $l = trim($l);
    $r = fetch_rss($l);
    foreach ($r->items as $id => $i) { 
        if (strlen($i['title']) > $maxlen)
            $r->items[$id]['title'] = substr($i['title'], 0, $maxlen).'...';

        if (isset($i['date_timestamp']) && plainage($i['date_timestamp']) > $maxage)
            unset($r->items[$id]);
    }

    if (count($r->items) > $maxcount)
        $r->items = array_slice($r->items, 0, $maxcount);

    if (count($r->items))
        $rss[] = $r;
}

include "template.php";
?>

<?php
require 'magpierss/rss_fetch.inc';

$maxlen = 600;
$maxage = 31*60*24;
$maxcount = 10;

function age($t) {
    $age = time()-$t;

    $tokens = array (
        31536000 => 'y',
        2592000 => 'm',
        604800 => 'w',
        86400 => 'd',
        3600 => 'h',
        60 => 'm',
        1 => 's'
    );

    foreach ($tokens as $unit => $text) {
        if ($age < $unit)
            continue;
        $numberOfUnits = floor($age / $unit);
        return $numberOfUnits.' '.$text;
    }
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

function clean($s) {
//    $s = strip_tags($s);
    $s = nl2br($s); 
    $s = htmlentities($s, ENT_COMPAT, 'UTF-8');
    $s = addslashes($s);
    return $s;
}

$f = file('feeds.txt');

$rss = array();

foreach ($f as $l) {
    $l = trim($l);
    $r = fetch_rss($l);

    foreach ($r->items as $id => $i) {
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

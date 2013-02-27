<?php 
$cd = 0;
?>
<html>
    <head>
        <title>News aggregation</title>
        <link rel='stylesheet' type='text/css' href='news.css' />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
        <script language="JavaScript" src="http://www.bosrup.com/web/overlib/overlib.js"></script>
        <script>
            overlib_pagedefaults(WIDTH, 500, FGCOLOR, '#ffffcc', BGCOLOR,'#668866');
        </script>
    </head>
    <body>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<?php   foreach ($rss as $r): ?>
<?php       if ($r == 'clear'): ?>
    <div class='clearer'></div> 
<?php       continue; endif; ?>
    <div class='feed'>
        <a class='title' href='<?= $r->channel['link'] ?>'><?= $r->channel['title'] ?></a><br />
    <?php foreach ($r->items as $i): $id++; ?>
        <a 
            class='link' 
            style='opacity: <?= ageToOpacity($i['date_timestamp']) ?>' 
            href='<?= $i['link']?>' 
            onmouseover="overlib($('#n<?= $id ?>').html())"
            onmouseout='nd();'
            >
        <?php if (isset($i['date_timestamp'])): ?>
            <span class='mini'>[<?= age($i['date_timestamp']) ?>]</span>
        <?php endif; ?>
            <?= $i['title'] ?></a><br />
        <div id='n<?= $id ?>' class='invisible'>
            <b><?= $i['pubdate']; ?></b><br />
            <?= $i['description']; ?>
        </div>
    <?php   endforeach; ?>
    </div>
    <?php   endforeach; ?>
	<img class='graph' src='https://www.google.com/finance/chart?num=10&hl=en&safe=off&client=opera&hs=HEu&tbo=d&channel=suggest&q=CURRENCY:AUDEUR&tkr=1&p=3M&chst=vkc&chs=1587x105&chsc=1' alt='AUDEUR' />
    </body>
</html>
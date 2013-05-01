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
            <?= strip_tags($i['title']) ?>
		</a>
        <div id='n<?= $id ?>' class='content invisible'>
            <b><?= $i['pubdate']; ?></b><br />
            <?= clean($i['description']); ?>
        </div>
    <?php   endforeach; ?>
    </div>
    <?php   endforeach; ?>
	<?php
	if (file_exists('custom.php'))
		include('custom.php');
	?>
		<div id='footer'>&copy;2013 <a href='http://flupps.net/'>Philipp Gruber</a></div>
    </body>
</html>

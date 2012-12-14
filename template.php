<html>
    <head>
        <title>News aggregation</title>
        <link rel='stylesheet' type='text/css' href='news.css' />
    </head>
    <body>
<?php   foreach ($rss as $r): ?>
    <div class='feed'>
    <a class='title' href='<?= $r->link ?>'><?= $r->channel['title'] ?></a><br />
    <?php foreach ($r->items as $i): ?>
        <?php if (isset($i['date_timestamp'])): ?>
            <span class='mini'>
                [<?= age($i['date_timestamp']) ?>]
            </span>
        <?php endif; ?>
        <a class='link' style='opacity: <?= ageToOpacity($i['date_timestamp']) ?>' href='<?= $i['link']?>'><?= $i['title'] ?></a><br />
        <div class='invisible'>
            <?= $i['pubdate']; ?><br />
            <?= $i['description']; ?><br />
            <?= $i['summary']; ?>
        </div>
    <?php   endforeach; ?>
    </div>
    <?php   endforeach; ?>
    </body>
</html>

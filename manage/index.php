<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
?>
<div data-role="header" data-fullscreen="true" data-id="hdr" data-tap-toggle="false" data-visible-on-page-show="true">
    <h1>Manage Feeds</h1>
</div><!-- /header -->
<ul>
    <li><a href="edit.php?id=new">ADD NEW</a></li>
<?php foreach($cmx->getFeeds() as $feed): ?>
    <li><a href="edit.php?id=<?php echo $feed->id ?>"><?php echo $feed->name ?></a></li>
<?php endforeach; ?>
</ul>

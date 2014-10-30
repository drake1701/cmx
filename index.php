<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
?>
	<div data-role="content" class="cmx-image">
	    <?php $feeds = $cmx->getUnreadFeeds() ?>
	    <?php foreach($feeds as $feed): ?>
	        <div class="feed-icon" style="background-image: url(<?php echo $feed->preview ?>);" onclick="window.location = '<?php echo "/view.php?id=".$feed->id ?>'">
	            <h3><?php echo $feed->name ?></h3>
	            <h4><?php echo $feed->count . " post" .($feed->count > 1 ? "s" : "") ?></h4>
	        </div>
	    <?php endforeach; ?>
	</div><!-- /content -->
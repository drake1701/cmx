<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
?>
<div data-role="page" data-theme="b" class="cmx-home">
	<div data-role="content" class="cmx-image">
	    <?php $feeds = $cmx->getUnreadFeeds() ?>
	    <?php foreach($feeds as $feed): ?>
	        <div class="feed-icon" style="background-image: url(<?php echo $feed->preview ?>);" onclick="window.location = '<?php echo "/view.php?feed=".$feed->id ?>'">
	            <div data-role="header"><?php echo $feed->name ?>
    	            <div data-role="button"><?php echo $feed->count . " post" .($feed->count > 1 ? "s" : "") ?></div>
	            </div>
	        </div>
	    <?php endforeach; ?>
	</div><!-- /content -->

    <div data-role="footer" data-position="fixed" data-fullscreen="true" data-id="ftr" data-tap-toggle="false" show="false">
    </div><!-- /footer -->
</div>
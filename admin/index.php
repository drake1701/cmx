<?php
/**
 * @author        Dennis Rogers
 * @address        www.drogers.net
 */
?>
<?php
require_once( "../app/Cmx.php" );
$cmx = new Cmx_App();
?>
<?php require_once( '../includes/header.php' ); ?>
<div data-role="page" data-theme="a" class="cmx-home">
    <?php if ( ! empty( $_REQUEST['action'] ) ): ?>
        <?php $feed = $cmx->getFeed( $_REQUEST['id'] ); ?>
        <div data-role="header">
            <h1><?php echo isset( $feed->name ) ? $feed->name : '' ?></h1>
            <a href="<?php echo $cmx->baseUrl . 'admin' ?>" class="ui-btn ui-btn-inline">Back</a>
            <a href="<?php echo $cmx->baseUrl ?>" class="ui-btn ui-btn-inline">View</a>
        </div>
    <?php endif; ?>
    <?php switch ( $_REQUEST['action'] ):
        case "save":
            $feed = $cmx->saveFeed( $_POST );
        case "test": ?>
            <div class="ui-grid-a">
                <?php $test = $cmx->testFeed( $_REQUEST['id'] ); ?>
                <div class="ui-block-a"><textarea><?php print_r( $test ) ?></textarea></div>
                <div class="ui-block-b" style="max-height:300px;"><?php if ( isset( $test['image'] ) ): ?><img
                        src="<?php echo $test['image'] ?>" /><?php endif; ?></div>
            </div>
        <?php case "view": ?>
            <div data-role="content">
                <a href="?action=test&id=<?php echo $feed->id ?>" data-role="button" data-ajax="false">Test</a>
                <form method="post" action="?">
                    <?php foreach ( $cmx->columns as $col ): ?>
                        <div data-role="fieldcontain">
                            <label for="<?php echo $col ?>"><?php echo $col ?></label>
                            <input type="text" id="<?php echo $col ?>" name="<?php echo $col ?>"
                                   value="<?php echo isset( $feed->$col ) ? htmlentities( $feed->$col ) : '' ?>"/>
                        </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="id" value="<?php echo isset( $feed->id ) ? $feed->id : 'new' ?>"/>
                    <input type="hidden" name="action" value="save"/>
                    <button type="submit" data-theme="b">Save</button>
                </form>
            </div>
            <?php break; ?>
        <?php default: ?>
            <div data-role="header">
                <h1>Admin</h1>
                <a href="<?php echo $cmx->baseUrl ?>" class="ui-btn ui-btn-inline" data-ajax="false">View</a>
            </div>
            <div data-role="content">
                <ul data-role="listview">
                    <?php foreach ( $cmx->getFeeds( 1 ) as $feed ): ?>
                        <li>
                            <a href="?action=view&id=<?php echo isset( $feed->id ) ? $feed->id : '' ?>">
                                <h3><?php echo isset( $feed->name ) ? $feed->name : '' ?></h3>
                                <p>
                                    Latest: <?php echo isset( $feed->lastdate ) ? $feed->lastdate : '' ? date( "l, M jS, Y", strtotime( $feed->lastdate ) ) : 'none' ?>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="?id=0">
                            <h3>Add New</h3>
                        </a>
                    </li>
                </ul>
            </div>
            <?php break; ?>
        <?php endswitch; ?>
</div>
<?php require_once( '../includes/footer.php' ); ?>

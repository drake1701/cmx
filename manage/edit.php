<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

if(!empty($_POST) && !empty($_POST['id'])){
    // do save
}

if(!isset($feed)){
    $feed = $cmx->getFeed($_REQUEST['id']);
}
?>
<div data-role="content">
    <form action="edit.php" method="post">
        <fieldset class="ui-grid-a">
            <?php foreach($feed as $key => $value): ?>
                <div class="ui-field-contain">
                    <label for="<?php echo $key ?>"><?php echo $key ?></label>
                    <?php if(preg_match("#regex#", $key)): ?>
                        <textarea type="text" name="<?php echo $key ?>"><?php echo $value ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?php echo $key ?>" value="<?php echo $value ?>" placeholder="<?php echo $key ?>" /><br />
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <input type="submit" value="Save" />
        </fieldset>
    </form>
</div>
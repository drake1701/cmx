<?php
/**
 * @author     Dennis Rogers <dennis@drogers.net>
 * @address    www.drogers.net
 * @date       1/12/15
 */

require('includes/header.php');

$comicId = isset($_GET['comic']) ? (int)$_GET['comic'] : 0;
if($comicId) {
    $cmx->markRead($comicId);
}

?>
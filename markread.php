<?php
/**
 * @author     Dennis Rogers <dennis@drogers.net>
 * @address    www.drogers.net
 * @date       1/12/15
 */

require_once("app/Cmx.php");
$cmx = new Cmx_App();

$comicId = isset($_GET['comic']) ? (int)$_GET['comic'] : 0;
if($comicId) {
    $cmx->markRead($comicId);
}

?>
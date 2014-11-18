<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

if(empty($argv[1])){
    die("Usage: php textrx.php [id]\n");
}

require_once(dirname(__FILE__)."/../app/Cmx.php");

$cmx = new Cmx_App();

$feed = $cmx->getFeed($argv[1]);
$comic = $cmx->fetchNew($feed, 1);

print_r($comic);



<?php
/**
 * @package		PaperRoll
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

require_once(dirname(__FILE__)."/../app/Cmx.php");

$cmx = new Cmx_App();

if(count($argv) < 3){
    die("Usage: pull_archive.php [feed_id] [count/date]\n");
}

$cmx->log("-------------------");
$cmx->log("Start Pull Archive");
$cmx->log("-------------------");

if(is_numeric($argv[2])){
    // archive until count
    
    // get today's
    $feed = $cmx->getFeed($argv[1]);
    $comic = $cmx->fetchNew($feed, 1);
    if(!$comic) die("no comic found\n");
    $i = 1;
    while($i++ < $argv[2]) {
        if($comic->prev == '') die("no previous comic found\n");
        $pageHtml = $cmx->getPage($comic->prev);
        $data = $cmx->buildComic($feed, $pageHtml, 1);
        $comic = $cmx->addComic($data);
    }
} else {
    // archive until date
}


$cmx->log("-------------------");
$cmx->log("End Pull Archive");
$cmx->log("-------------------");
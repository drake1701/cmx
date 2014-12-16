<?php
/**
 * @package		PaperRoll
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

require_once(dirname(__FILE__)."/../app/Cmx.php");

$cmx = new Cmx_App();
$cmx->log("-------------------");
$cmx->log("Start Fetch New");
$cmx->log("-------------------");
$cmx->fetchNewAll(isset($argv[2]));
$cmx->log("-------------------");
$cmx->log("End Fetch New");
$cmx->log("-------------------");
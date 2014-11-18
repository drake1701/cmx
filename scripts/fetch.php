<?php
/**
 * @package		PaperRoll
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

require_once(dirname(__FILE__)."/../app/Cmx.php");

$cmx = new Cmx_App();

$cmx->fetchNewAll(isset($argv[2]));
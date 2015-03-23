<?php 
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
 
require_once(dirname(__FILE__)."/../app/Cmx.php");

$cmx = new Cmx_App();

$images = glob($cmx->baseDir . 'images/*');
$images = array_merge($images, glob($cmx->baseDir . 'images/*/*'));
$images = array_merge($images, glob($cmx->baseDir . 'images/*/*/*'));

$sql = 'SELECT count(*) as count FROM comic WHERE image = ?';
$cmx->log("-------------------");
$cmx->log("Start Files Cleanup");
$cmx->log("-------------------");
foreach($images as $image){
    if(!is_dir($image)){
        $url = str_replace($cmx->baseDir, $cmx->baseUrl, $image);
        $statement = $cmx->db->prepare($sql);
        $statement->execute(array($url));
        $count = $statement->fetchObject()->count;
        if($count == 0) {
            $cmx->log("Removing orphaned file $image");
            unlink($image);
        }
    }
}
$cmx->log("-------------------");
$cmx->log("End Files Cleanup");
$cmx->log("-------------------");
 ?>
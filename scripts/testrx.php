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

$statement = $cmx->db->prepare("SELECT * FROM 'feed' WHERE id = ?;");
$statement->execute(array($argv[1]));

$feed = $statement->fetchObject();

echo "Testing $feed->name\n";

$filename = $cmx->baseDir."var/".$cmx->underscore($feed->url).".html";

if(!file_exists($filename)){
    echo " - getting fresh file http://cmx.drogers.net/$filename\n";
    file_put_contents($filename, $cmx->getPage($feed->url));
}

$pageHtml = file_get_contents($filename);

$comic = array();

if($feed->regex) {
    preg_match("#".$feed->regex."#", $pageHtml, $image);
    if(empty($image[1])){
        echo "No image found\n";
    } else {
        $comic["image"] = $image[1];
    }
} else {
    echo "No image regex set\n";
}

foreach(array("note", "permalink", "comicid", "date", "title") as $key){
    $rx = $key."_regex";
    if($feed->$rx){
        preg_match("#".$feed->$rx."#", $pageHtml, $data);
        if(!empty($data[1])){
            if($key == "date"){
                if(preg_match("#^\d\d\d\d\d\d$#", $data[1])){
                    $data[1] = substr($data[1], 0, 2)."-".substr($data[1], 2, 2)."-".substr($data[1], 4, 2);
                }
                $comic[$key] = date("Y-m-d", strtotime($data[1]));
            }
            else
                $comic[$key] = trim($data[1]);
        } else {
            echo "No $key found\n";
        }
        if(empty($comic['title']) && !empty($comic['date']))
            $comic['title'] = date("F jS, Y", strtotime($comic['date']));
        if(preg_match("#http#", $comic['image']) == false)
            $comic['image'] = $feed->url . "/" . $comic['image'];
        if(empty($comic['permalink']) && !empty($comic['comicid']))
            
    } else {
        echo "No $key regex set\n";
    }
}

print_r($comic);



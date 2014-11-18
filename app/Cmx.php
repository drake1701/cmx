<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

class Cmx_App
{

    public $db;
    public $baseDir = '/var/www/development/cmx/';
    public $baseUrl = 'http://cmx.drogers.net/';
    protected $feeds;
    protected $unreadFeeds;
    protected $comics = array();
    
    function __construct() {
        $this->db = new PDO('sqlite:'.$this->baseDir.'cmx.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /* Load specific feed by id */
    public function getFeed($feedId) {
        $feedRequest = $this->db->prepare('SELECT * FROM `feed` WHERE id = ?;');
        $feedRequest->execute(array($feedId));
        
        $feed = $feedRequest->fetchObject();
        return $feed;
    }
    
    /* Load all feeds */
    public function getFeeds() {
        if(empty($this->feeds)){
            $feedRequest = $this->db->prepare('SELECT * FROM `feed` ORDER BY `name` ASC;');
            $feedRequest->execute();
            
            $feeds = array();
            while($row = $feedRequest->fetchObject()){
                $feeds[] = $row;
            }
            $this->feeds = $feeds;
        }
        return $this->feeds;
    }
    
    /* Load unread comics from a feed */
    public function getUnreadFeedComics($feedId) {
        if(empty($this->comics[$feedId])){
            $comicRequest = $this->db->prepare('SELECT * FROM `comic` WHERE `read` = 0 AND `feed_id` = ? ORDER BY `date` ASC;');
            $comicRequest->execute(array($feedId));
            
            $comics = array();
            while($row = $comicRequest->fetchObject()){
                $comics[] = $row;
            }
            $this->comics[$feedId] = $comics;
        }
        return $this->comics[$feedId];
    }    
    
    /* Load all feeds with unread posts */
    public function getUnreadFeeds() {
        if(empty($this->unreadFeeds)){
            $feedRequest = $this->db->prepare('SELECT f.*, c.image AS `preview`, count(*) AS `count` FROM `feed` f JOIN `comic` c ON c.feed_id = f.id GROUP BY c.feed_id ORDER BY c.date DESC;');
            $feedRequest->execute();
            
            $feeds = array();
            while($row = $feedRequest->fetchObject()){
                $feeds[] = $row;
            }
            $this->unreadFeeds = $feeds;
        }
        return $this->unreadFeeds;        
    }
    
    /* Add comic to feed */
    public function addComic($data) {
        $columns = array();
        $placeholders = array();
        foreach($data as $column => $value){
            $columns[] = "`$column`";
            $placeholders[] = ":$column";
            $data[":$column"] = $value;
        }
        $sql = 'INSERT INTO `comic` ('.implode(',', $columns).') VALUES ('.implode(',', $placeholders).');';
        $statement = $this->db->prepare($sql);
        
        $statement->execute($data);
    }
    
    /* Load latest comic from feed site into db */
    public function fetchNewAll($force = false) {
        foreach($this->getFeeds() as $feed){
            $this->fetchNew($feed, $force);
        }
    }
    
    public function fetchNew($feed, $force) {

        echo "Checking feed '$feed->name' ($feed->url)\n";
        // get page html
        $pageHtml = $this->getPage($feed->url, $force);
        if($feed->url_regex){
            preg_match('#'.$feed->url_regex.'#s', $pageHtml, $data);
            print_r($data);
            $pageHtml = $this->getPage(trim($data[1]), $force);
        }
        
        // look for image first of all
        preg_match('#'.$feed->regex.'#s', $pageHtml, $image);
        if(empty($image[1])){
            echo "Error: No image found for {$feed->name}\n";
            return false;
        }
        // handle internal links
        if(preg_match('#http#s', $image[1]) == false)
            $image[1] = $feed->url . $image[1];
        // save image locally
        $imagePath = $this->baseDir.'images/'.$this->underscore($feed->name).'/'.$this->underscore(basename($image[1]));
        if($force or !file_exists($imagePath)){
            echo "getting new comic $imagePath\n";
            $this->getImage($image[1], $imagePath);
            
            // initialize record
            $comic = array(
                'image' => $imagePath,
                'feed_id' => $feed->id
            );
            
            // get other fields
            foreach(array('note', 'permalink', 'date', 'title', 'comicid') as $key){
                $rx = $key.'_regex';
                if($feed->$rx){
                    preg_match('#'.$feed->$rx.'#s', $pageHtml, $data);
                    if(!empty($data[1])){
                        if($key == 'date'){
                            // parse weird date formats
                            if(preg_match('#^\d\d\d\d\d\d$#s', $data[1])){
                                $data[1] = substr($data[1], 0, 2).'-'.substr($data[1], 2, 2).'-'.substr($data[1], 4, 2);
                            }
                            $comic[$key] = date('Y-m-d', strtotime($data[1]));
                        } if($key == 'comicid') {
                            // generate permalink from comicid
                            $regex = explode('|', $feed->$rx);
                            preg_match('#'.$regex[0].'#s', $pageHtml, $data);
                            $comic['permalink'] = preg_replace('#'.$regex[0].'#s', $regex[1], $data[0]);
                        } else
                            $comic[$key] = trim($data[1]);
                    }
                }
            }
            
            // handle internal urls
            if(preg_match('#http#s', $comic['permalink']) == false)
                $comic['permalink'] = $feed->url . $comic['permalink'];
            
            // use todays date if none found
            if(empty($comic['date']))
                $comic['date'] = date('Y-m-d');
                
            // use date for title if none found
            if(empty($comic['title']) && !empty($comic['date']))
                $comic['title'] = date('F jS, Y', strtotime($comic['date']));
            // fix image url
            $comic['image'] = $this->baseUrl.'images/'.$this->underscore($feed->name).'/'.$this->underscore(basename($image[1]));
            // save
            $this->addComic($comic);
            
            return $comic;
        }        
    }
        
    /* convert strings for filenames */
    public function underscore($string) {
        $string = strtolower($string);
        $string = preg_replace('#[^a-z0-9 \.]#s', '', $string);
        $string = str_replace(' ', '_', $string);
        return $string;
    }
    
    /* load external html page */
    public function getPage($url, $cache = false) {
        if($cache){
            $filename = $this->baseDir."var/".$this->underscore($url).".html";
            if(file_exists($filename)){
                return file_get_contents($filename);
            }
            echo "getting fresh file for $url\n";
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        $html = curl_exec($ch);
        if($cache)
            file_put_contents($filename, $html);
        return $html;
    }
    
    /* load external comic image */
    public function getImage($url, $path) {
        echo "get image $url\n";
        $destParts = pathinfo($path);
        if(!is_dir($destParts['dirname'])){
            mkdir($destParts['dirname'], 0777, true);
        }
        
        $url = str_replace(' ', '%20', $url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        $imgData = curl_exec($ch);
        file_put_contents($path, $imgData);
    }

}

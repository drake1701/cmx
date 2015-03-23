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
    public $columns = array('name', 'url', 'url_regex', 'regex', 'note_regex', 'permalink_regex', 'comicid_regex', 'date_regex', 'title_regex', 'prev_regex');
    protected $feeds;
    protected $unreadFeeds;
    protected $comics = array();
    protected $firstUnread = array();
    
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
    
    public function saveFeed($data) {
        $feedData = array();
        
        if(isset($data['id']) && $data['id'] > 0) {
            $feedSql = 'UPDATE `feed` SET ';
            $bindings = array();
            foreach($this->columns as $col){
                if(empty($data[$col])) continue;
                $bindings[] = "`{$col}` = :{$col}";
                $feedData[':'.$col] = $data[$col];
            }
            $feedSql .= implode(',', $bindings);
            $feedSql .= ' WHERE `id` = :id';
            $feedData[':id'] = $data['id'];
        } else {
            $feedSql = 'INSERT INTO `feed` ';
            $feedCols = array();
            $feedBinds = array();
            foreach($this->columns as $col){
                if(empty($data[$col])) continue;
                $feedCols[] = $col;
                $feedBinds[] = ':'.$col;
                $feedData[':'.$col] = $data[$col];
            }
            $feedSql .= '('.implode(',', $feedCols).') VALUES ('.implode(',', $feedBinds).')';
        }
        
        $feedRequest = $this->db->prepare($feedSql);
        $feedRequest->execute($feedData);
        
        return $this->getFeed($feedData[':id']);
    }
    
    public function testFeed($feedId) {
        if(!is_numeric($feedId)) {
            echo "Invalid feed id.";
            return;
        }
        
        $feed = $this->getFeed($feedId);
        if(!isset($feed->id)) {
            echo "Feed not found.";
            return;
        }
        
        return $this->fetchNew($feed, true);
    }
    
    /* Load specific feed by id */
    public function getComic($comicId, $image = false) {
        if($image)
            $comicRequest = $this->db->prepare('SELECT * FROM `comic` WHERE image = ?;');
        else 
            $comicRequest = $this->db->prepare('SELECT * FROM `comic` WHERE id = ?;');
        $comicRequest->execute(array($comicId));
        
        $comic = $comicRequest->fetchObject();
        return $comic;
    }
    
    /* Load all feeds */
    public function getFeeds($stats = false) {
        if(empty($this->feeds)){
            if($stats){
                $feedRequest = $this->db->prepare('SELECT f.id, f.name, c.date as lastdate FROM `feed` f LEFT OUTER JOIN `comic` c ON (c.feed_id = f.id) GROUP BY f.id, f.name ORDER BY c.date ASC;');
            } else {
                $feedRequest = $this->db->prepare('SELECT * FROM `feed` ORDER BY `name` ASC;');
            }
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
    public function getFeedComics($feedId, $archive = false) {
        if(empty($this->comics[$feedId])){
            $comicRequest = $this->db->prepare('SELECT * FROM `comic` WHERE `feed_id` = ?'.($archive ? '' : ' AND `read` != 1').' ORDER BY date(`date`) ASC, permalink ASC;');
            $comicRequest->execute(array($feedId));
            
            $comics = array();
            while($row = $comicRequest->fetchObject()){
                $comics[$row->id] = $row;
            }
            $this->comics[$feedId] = $comics;
        }
        return $this->comics[$feedId];
    }
    
    /* Get first unread comic id from a feed */
    public function getFirstUnreadComicId($feedId) {
        if(empty($this->firstUnread[$feedId])){
            $comicRequest = $this->db->prepare('SELECT * FROM `comic` WHERE `read` != 1 AND `feed_id` = ? ORDER BY date(`date`) ASC LIMIT 1;');
            $comicRequest->execute(array($feedId));
            
            $row = $comicRequest->fetchObject();
            $this->firstUnread[$feedId] = $row->id;
        }
        return $this->firstUnread[$feedId];
    }      
    
    /* Load all feeds with unread posts */
    public function getUnreadFeeds() {
        if(empty($this->unreadFeeds)){
            $feedRequest = $this->db->prepare('SELECT f.*, c.image AS `preview`, count(*) AS `count` FROM `feed` f JOIN `comic` c ON c.feed_id = f.id WHERE read != 1 GROUP BY c.feed_id ORDER BY date(c.date) ASC;');
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
        $comicData = array();
        foreach($data as $column => $value){
            $columns[] = "`$column`";
            $placeholders[] = ":$column";
            if($column == 'date')
                $comicData[":$column"] = $this->formatDate($value);
            else
                $comicData[":$column"] = $value;
        }
        $sql = 'INSERT INTO `comic` ('.implode(',', $columns).') VALUES ('.implode(',', $placeholders).');';
        $statement = $this->db->prepare($sql);
        
        $statement->execute($comicData);
        return $this->getComic($this->db->lastInsertId());
    }
    
    /* Mark read */
    public function markRead($comicId) {
        $sql = 'UPDATE comic SET read = 1 WHERE id = ?';
        $statement = $this->db->prepare($sql);
        self::log("mark read $comicId");
        $statement->execute(array($comicId));
    }
    
    /* Load latest comic from feed site into db */
    public function fetchNewAll($force = false) {
        foreach($this->getFeeds() as $feed){
            $this->fetchNew($feed, $force);
        }
    }
    
    public function fetchNew($feed, $test = false) {
        try{
            self::log("Checking feed '$feed->name' ($feed->url)");
            // get page html
            $pageHtml = $this->getPage($feed->url);
            if($feed->url_regex){
                preg_match('#'.$feed->url_regex.'#s', $pageHtml, $data);
                self::log($data);
                $pageHtml = $this->getPage(trim($data[1]));
                $comic = $this->buildComic($feed, $pageHtml, $test, trim($data[1]));
            } else {
                $comic = $this->buildComic($feed, $pageHtml, $test);
            }
            if($test) {
                return $comic;
            }
            
            if($comic && empty($comic->id)) {
                return $this->addComic($comic);
            } else {
                self::log("No new comic found.");
            }
        } Catch (Exception $e) {
        	return $e->getMessage()."\n".$e->getTraceAsString();
        }
        return;
    }
    
    public function buildComic($feed, $pageHtml, $test = false, $permalink = '') {

        // look for image first of all
        preg_match('#'.$feed->regex.'#s', $pageHtml, $image);
        if(empty($image[1])){
            self::log("Error: No image found for {$feed->name}", 1);
            throw new Exception("Error: No image found for {$feed->name}");
        }
        // handle internal links
        if(preg_match('#http#s', $image[1]) == false)
            $image[1] = $feed->url . $image[1];
            
        // save image locally
        $imagePath = 'images/'.$this->underscore($feed->name).'/'.$this->underscore(basename($image[1]));
        
        $comic = $this->getComic($this->baseUrl.$imagePath, true);
        if($comic && !$test)
            return $comic;

        self::log("getting new comic image {$image[1]}");
        $this->getImage($image[1], $this->baseDir.$imagePath);
        
        // initialize record
        $comic = array(
            'image' => $this->baseUrl.$imagePath,
            'feed_id' => $feed->id,
            'permalink' => $permalink
        );
        
        // get other fields
        foreach(array('note', 'permalink', 'date', 'title', 'comicid', 'prev') as $key){
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
                        $comic['permalink'] = preg_replace('#'.$regex[0].'#se', $regex[1], $data[0]);
                    } else
                        $comic[$key] = trim($data[1]);
                }
            }
        }
        
        // use comic url for permalink if none found
        if($comic['permalink'] == '') $comic['permalink'] = $feed->url;
        
        // handle internal urls
        if(preg_match('#http#s', $comic['permalink']) == false)
            $comic['permalink'] = $feed->url . $comic['permalink'];
        if(isset($comic['prev']) && preg_match('#http#s', $comic['prev']) == false)
            $comic['prev'] = $feed->url . $comic['prev'];
        
        // use todays date if none found
        if(empty($comic['date']))
            $comic['date'] = date('Y-m-d');
            
        // use date for title if none found
        if(empty($comic['title']) && !empty($comic['date']))
            $comic['title'] = date('F jS, Y', strtotime($comic['date']));
        
        return $comic;
    }
    
        
    /* convert strings for filenames */
    public function underscore($string) {
        $string = strtolower($string);
        $string = preg_replace('#[^a-z0-9 \.]#s', '', $string);
        $string = str_replace(' ', '_', $string);
        return $string;
    }
    
    public function formatDate($string) {
        $date = new DateTime($string);
        return $date->format('Y-m-d H:i:s');
    }
    
    /* load external html page */
    public function getPage($url, $cache = false) {
        self::log("get url $url");
        $filename = $this->baseDir."var/cache/".$this->underscore($url).".html";
        if($cache){
            if(!is_dir(dirname($filename))){
                mkdir(dirname($filename), 0777, true);
            }  
            if(file_exists($filename)){
                return file_get_contents($filename);
            }
        }
        self::log("getting fresh file for $url");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        $html = curl_exec($ch);
        file_put_contents($filename, $html);
        return $html;
    }
    
    /* load external comic image */
    public function getImage($url, $path) {
        if(file_exists($path)) return true;
        $destParts = pathinfo($path);
        if(!is_dir($destParts['dirname'])){
            mkdir($destParts['dirname'], 0777, true);
        }
        
        $url = str_replace(' ', '%20', $url);
        self::log("get image $url");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
        $imgData = curl_exec($ch);
        file_put_contents($path, $imgData);
    }
    
    public function log($message, $error = false) {
        if($error)
            $file = $this->baseDir . 'var/log/error.log';
        else
            $file = $this->baseDir . 'var/log/system.log';
         
        if(!is_dir(dirname($file))){
            mkdir(dirname($file), 0777, true);
        }        
            
 	    if (is_array($message) || is_object($message)) {
	        $message = print_r($message, true);
	    }
	    
	    $fp = fopen($file, 'a');       
	    fputs($fp, $message."\n");
	    fclose($fp);
    }

}








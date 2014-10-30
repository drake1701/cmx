<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
 
$db = new PDO('sqlite:'.dirname(__FILE__).'/../cmx.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("DROP TABLE IF EXISTS comic;");
$db->exec("CREATE TABLE 'comic' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'feed_id' INTEGER, 'permalink' TEXT, 'image' TEXT,'note' TEXT, 'title' TEXT, 'date' DATETIME, 'read' BOOLEAN DEFAULT 'false')");

$db->exec("DROP TABLE IF EXISTS 'feed';");
$db->exec("CREATE TABLE 'feed' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'url' TEXT, 'url_regex' TEXT, 'name' TEXT, 'regex' TEXT, 'note_regex' TEXT, 'permalink_regex' TEXT, 'comicid_regex' TEXT, 'date_regex' TEXT, 'title_regex' TEXT)");

$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Penny Arcade',
		'http://www.penny-arcade.com/comic',
		'id=\"comicFrame\".+?src=\"(.+?)\"',
		'',
		'<a href=\"(.+?)\".+?Read News Post',
		'<a href=\".+?post/([/0-9]*).+?\".+?Read News Post',
		'<title>.+?- (.+?)</title>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Bearmageddon',
		'http://bearmageddon.com',
		'class=\"comicpane\".+?src=\"(.+?)\"',
		'class=\"comicpane\".+?title=\"(.+?)\"',
		'class=\"post-title\".+?href=\"(.+?)\"',
		'Last Update: (.+?) //',
		'<title>.+?- (.+?)</title>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Ctrl+Alt+Del',
		'http://www.cad-comic.com/cad/',
		'img src=\"(.+?comics/cad.+?)\"',
		'',
		'addthis:url=\"(.+?)\"',
		'<title>.+?\((.+?)\)</title>',
		'img src=\".+?comics/cad.+?\" alt=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Loading Artist',
		'http://www.loadingartist.com/latest/',
		'class=\"comic\".+?src=\"(.+?)\"',
		'article id=\"post.+?comic type-comic.+?class=\"body\">(.+?)</div>',
		'property=\"og:url\".+?content=\"(.+?)\"',
		'<span class=\"date\">(.+?)</span>',
		'property=\"og:title\".+?content=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('The Brads - a comic about web design',
		'http://bradcolbow.com/',
		'src=\"([^\"]+?)\" class=\"retina\"',
		'',
		'class=\"entry\".+?href=\"(.+?)\"',
		'',
		'<img.+?class=\"retina\".+?alt=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('HijiNKS ENSUE - A Geek Webcomic',
		'http://hijinksensue.com',
		'id=\"comic\".+?src=\"(.+?)\"',
		'id=\"comic\".+?alt=\"(.+?)\"',
		'<h2 class=\"post-title\"><a href=\"(.+?)\"',
		'<span class=\"post-date\">(.+?)</span>',
		'<h2 class=\"post-title\"><a.+?>(.+?)</a>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Girls With Slingshots',
		'http://www.girlswithslingshots.com/',
		'id=\"comicbody\".+?src=\".+?\.\./(.+?)\"',
		'id=\"comicbody\".+?title=\"(.+?)\"',
		'id=\"newsheader\".+?href=\"(.+?)/comments/\"',
		'class=\"cc-publishtime\">posted (.+?) at',
		'<title>.+?- (.+?)</title>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Evil Inc - A daily comic about super-villains',
		'http://evil-inc.com',
		'id=\"comic\".+?src=\"(.+?)\?.+?\"',
		'',
		'td class=\"comic-nav\"><a href=\"([^\"]+?)/\#comments\"',
		'class=\"post-date\">(.+?)</span>',
		'class=\"post-title\">(.+?)</h2>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('PvPonline',
		'http://sorethumbs.keenspot.com',
		'class=\"ksc\".+?src=\"(.+?)\"',
		'',
		'rel=\"canonical\" href=\"(.+?)\" />',
		'rel=\"canonical\" href=\"http://sorethumbs.keenspot.com/d/(.+?).html\" />',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Marry Me',
		'http://marryme.keenspot.com',
		'class=\"ksc\".+?src=\"(.+?)\"',
		'',
		'rel=\"canonical\" href=\"(.+?)\" />',
		'rel=\"canonical\" href=\"http://marryme.keenspot.com/d/(.+?).html\" />',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, comicid_regex, date_regex, title_regex) VALUES
	('VG Cats',
		'http://www.vgcats.com/comics/',
		'src=\"archives.gif\".+?src=\"(.+?)\"',
		'',
		'href=\"\?strip_id=(\d+?)\"><img src=\"back.gif\"',
		'src=\"archives.gif\".+?src=\"images/(.+?)\.jpg\"',
		'<title>.+?- (.+?)</title>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Dinosaur Comics',
		'http://www.qwantz.com/index.php',
		'<img src=\"([^\"]+?)\" class=\"comic\"',
		'class=\"rss-title\">(.+?)</span>',
		'property=\"og:url\" content=\"(.+?)\"',
		'<title>Dinosaur Comics - (.+?) - awesome fun times!</title>',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('QC RSS',
		'http://www.questionablecontent.net',
		'>Random<.+?src=\"(.+?)\"',
		'id=\"news\">(.+?)<center',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('PANDALIKES',
		'http://pandalikeseng.blogspot.com/',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Tragedy Series',
		'http://tragedyseries.tumblr.com/',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Hark, A Vagrant!',
		'http://www.rsspect.com',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('garfield minus garfield',
		'http://garfieldminusgarfield.net/',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Real Life Comics',
		'http://reallifecomics.com',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Help Us Great Warrior!',
		'http://helpusgreatwarrior.tumblr.com/',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Sinfest',
		'http://www.sinfest.net',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Basic Instructions',
		'http://basicinstructions.net/basic-instructions/',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' ('url','regex','name','note_regex','permalink_regex','date_regex','title_regex') VALUES
	('http://www.xkcd.com/','id=\"comic\".+?src=\"(.+?)\"','XKCD','id=\"comic\".+?title=\"(.+?)\"','Permanent link to this comic: (.+?)<',NULL,'<title>(.+?)</title>'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('The Non-Adventures of Wonderella',
		'http://nonadventures.com',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Saturday Morning Breakfast Cereal (updated daily)',
		'http://www.smbc-comics.com',
		'',
		'',
		'',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex) VALUES
	('Poorly Drawn Lines',
		'http://poorlydrawnlines.com',
		'',
		'',
		'',
		'',
		''
	);");



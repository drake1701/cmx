<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
 
$db = new PDO('sqlite:'.dirname(__FILE__).'/../cmx.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("DROP TABLE IF EXISTS comic;");
$db->exec("CREATE TABLE 'comic' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'feed_id' INTEGER, 'permalink' TEXT, 'image' TEXT,'note' TEXT, 'title' TEXT, 'prev' TEXT, 'date' DATETIME, 'read' BOOLEAN DEFAULT 0)");

$db->exec("DROP TABLE IF EXISTS 'feed';");
$db->exec("CREATE TABLE 'feed' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'url' TEXT, 'url_regex' TEXT, 'name' TEXT, 'regex' TEXT, 'note_regex' TEXT, 'permalink_regex' TEXT, 'comicid_regex' TEXT, 'date_regex' TEXT, 'title_regex' TEXT, 'prev_regex' TEXT)");

$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Penny Arcade',
		'http://www.penny-arcade.com/comic',
		'id=\"comicFrame\".+?src=\"(.+?)\"',
		'',
		'property=\"og:url\" content=\"(.+?)\"',
		'<a href=\".+?post/([/0-9]*).+?\".+?Read News Post',
		'<title>.+?- (.+?)</title>',
		'btn btnPrev\" href=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Bearmageddon',
		'http://bearmageddon.com',
		'class=\"comicpane\".+?src=\"(.+?)\"',
		'class=\"comicpane\".+?title=\"(.+?)\"',
		'class=\"post-title\".+?href=\"(.+?)\"',
		'Last Update: (.+?) //',
		'<title>.+?- (.+?)</title>',
		'href=\"([^\"]+?)\" class=\"navi navi-prev\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Ctrl+Alt+Del',
		'http://www.cad-comic.com/cad/',
		'src=\"(.+?comics/cad.+?)\"',
		'',
		'addthis:url=\"(.+?)\"',
		'<title>.+?\((.+?)\)</title>',
		'img src=\".+?comics/cad.+?\" alt=\"(.+?)\"',
		'href=\"/cad/([^\"]+?)\" class=\"nav-back\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Loading Artist',
		'http://www.loadingartist.com/latest/',
		'class=\"comic\".+?src=\"(.+?)\"',
		'article id=\"post.+?comic type-comic.+?class=\"body\">(.+?)</div>',
		'property=\"og:url\".+?content=\"(.+?)\"',
		'<span class=\"date\">(.+?)</span>',
		'property=\"og:title\".+?content=\"(.+?)\"',
		'ir-prev\" href=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, url_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('The Brads',
		'http://bradcolbow.com/',
		'class=\"entry\".+?src=\"(.+?)\"',
		'\"comicicon-main\".+?href=\"(.+?)\"',
		'',
		'class=\"post\".+?<h5>(.+?)</h5>',
		'class=\"post\".+?<h2>(.+?)</h2>',
		'\"prev\".+?href=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('HijiNKS ENSUE',
		'http://hijinksensue.com',
		'id=\"comic\".+?src=\"(.+?)\"',
		'id=\"comic\".+?alt=\"(.+?)\"',
		'<h2 class=\"post-title\"><a href=\"(.+?)\"',
		'<span class=\"post-date\">(.+?)</span>',
		'<h2 class=\"post-title\"><a.+?>(.+?)</a>',
		'href=\"([^\"]+?)\" class=\"navi navi-prev-in\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, comicid_regex, date_regex, title_regex, prev_regex) VALUES
	('Girls With Slingshots',
		'http://www.girlswithslingshots.com/',
		'id=\"comicbody\".+?src=\".+?\.\./(.+?)\"',
		'id=\"comicbody\".+?title=\"(.+?)\"',
		'id=\"comicbody\".+?src=\".+?GWS(\d*)|http://www.girlswithslingshots.com/comic/gws-\\1/',
		'class=\"cc-publishtime\">posted (.+?) at',
		'<title>.+?- (.+?)</title>',
		'href=\"([^\"]+?)\" class=\"prev\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Evil Inc',
		'http://evil-inc.com',
		'id=\"comic\".+?src=\"(.+?)\?.+?\"',
		'',
		'td class=\"comic-nav\"><a href=\"([^\"]+?)/\#comments\"',
		'id=\"comic\".+?src=\".+?(\d\d\d\d\d\d\d\d+?).+?\?.+?\"',
		'class=\"post-title\">(.+?)</h2>',
		'class=\"mininav-prev\".+?href=\"(.+?)\"'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('PvPonline',
		'http://pvponline.com/comic/',
		'class=\"comic-art\".+?src=\"(.+?)\"',
		'',
		'http://www.facebook.com/sharer.php\?u=(.+?)\&',
		'class=\"comic-date.+?>(.+?)</div>',
		'<title>PVP - (.+?)</title>',
		'href=\"/comic/([^\"]+?)\".+?Prev'
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Marry Me',
		'http://marryme.keenspot.com',
		'class=\"ksc\".+?src=\"(.+?)\"',
		'',
		'rel=\"canonical\" href=\"(.+?)\" />',
		'rel=\"canonical\" href=\"http://marryme.keenspot.com/d/(.+?).html\" />',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, comicid_regex, date_regex, title_regex, prev_regex) VALUES
	('VG Cats',
		'http://www.vgcats.com/comics/',
		'src=\"archives.gif\".+?src=\"(.+?)\"',
		'',
		'href=\"\?strip_id=(\d+?)\"><img src=\"back.gif\"',
		'src=\"archives.gif\".+?src=\"images/(.+?)\.jpg\"',
		'<title>.+?- (.+?)</title>',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Dinosaur Comics',
		'http://www.qwantz.com/index.php',
		'<img src=\"([^\"]+?)\" class=\"comic\"',
		'class=\"rss-title\">(.+?)</span>',
		'property=\"og:url\" content=\"(.+?)\"',
		'<title>Dinosaur Comics - (.+?) - awesome fun times!</title>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, comicid_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('QC',
		'http://www.questionablecontent.net',
		'>Random<.+?src=\"(.+?)\"',
		'id=\"news\">(.+?)<center',
		'>Random<.+?src=\"http://www.questionablecontent.net/comics/(.+?).png\"|http://www.questionablecontent.net/view.php?comic=\\1',
		'',
		'id=\"news\">.+?<b>(.+?)</b>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, url_regex, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('PANDALIKES',
		'http://www.pandalikes.com/',
		'<p>eng</p>.+?<p><a href=\"(.+?)\"',
		'<div class=\"entry-attachment\">.+?<img src=\"(.+?)\"',
		'<div class=\"entry-attachment\">.+?<img.+? title=\"(.+?)\"',
		'<g:plusone.+?href=\"(.+?)\"',
		'',
		'<div class=\"entry-attachment\">.+?<img.+? title=\"(.+?)\"',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Tragedy Series',
		'http://tragedyseries.tumblr.com/',
		'<li class=\"posts\".+?img src=\"(.+?)\"',
		'<p class=\"tags\">(.+?)</p>',
		'<li class=\"posts\".+?a href=\"(.+?)\"',
		'<p class=\"info\".+?<a.+?>Posted on (.+?)</a>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Hark, A Vagrant!',
		'http://harkavagrant.com/',
		'class=\"rss-content\".+?<img src=\"(.+?)\"',
		'div class=\"black11.+?class=\"rss-content\">(.+?)</span>',
		'href=\"(.+?)\".+?buttonnext.png',
		'',
		'class=\"rss-content\".+?<img.+?title=\"(.+?)\"',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('garfield minus garfield',
		'http://garfieldminusgarfield.net/',
		'<div class=\"photo\".+?img src=\"(.+?)\"',
		'<p class=\"caption\">(.+?)</p>',
		'<div class=\"photo\".+?a href=\"(.+?)\"',
		'<a href=\"/day/.+?\">(.+?)</a>',
		'<div class=\"photo\".+?a href=\"http://garfieldminusgarfield.net/post/\d*/(.+?)\"',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Real Life Comics',
		'http://reallifecomics.com',
		'<div id=\"comic\".+?img src=\"(.+?)\"',
		'',
		'class=\"twitter-share-button\" data-url=\"(.+?)\"',
		'<div id=\"comic\".+?img.+?alt=\"(.+?)\"',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Help Us Great Warrior!',
		'http://helpusgreatwarrior.tumblr.com/',
		'<div class=\"photo\".+?img src=\"(.+?)\"',
		'<div class=\"caption\">(.+?)</div>',
		'<div class=\"photo\".+?a href=\"(.+?)\"',
		'<a title=\"link to this post\".+?>(.+?)</a>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, comicid_regex, date_regex, title_regex, prev_regex) VALUES
	('Sinfest',
		'http://www.sinfest.net/',
		'<img src=\"(btphp/comics/.+?.gif)\"',
		'',
		'<img src=\"btphp/comics/(.+?).gif\"|http://www.sinfest.net/view.php?date=\\1',
		'<nobr>(.+?): </nobr>',
		'<img src=\"btphp/comics/.+?alt=\"(.+?)\">',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Basic Instructions',
		'http://basicinstructions.net/',
		'class=\"body\".+?img src=\"/(.+?)\?',
		'',
		'<a class=\"permalink\" href=\"/(.+?)\">',
		'class=\"posted-on.+?<img.+?>(.+?)</span>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' ('url','regex','name','note_regex','permalink_regex','date_regex','title_regex', prev_regex) VALUES
	('http://www.xkcd.com/',
	'id=\"comic\".+?src=\"(.+?)\"',
	'XKCD',
	'id=\"comic\".+?title=\"(.+?)\"',
	'Permanent link to this comic: (.+?)<',NULL,'<title>(.+?)</title>',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('The Non-Adventures of Wonderella',
		'http://nonadventures.com',
		'id=\"comic\".+?img src=\"(.+?)\"',
		'id=\"comic\".+?img.+?title=\"(.+?)\"',
		'<h2>.+?<a href=\"(.+?)\" rel=\"bookmark\"',
		'data-datetime=\"(.+?)T.+?\"',
		'id=\"comic\".+?img.+?alt=\"(.+?)\"',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('SMBC',
		'http://www.smbc-comics.com',
		'id=\"comicimage\".+?src=''(.+?)''',
		'<p class=\"blogtext\">(.+?)</p>',
		'data-url=\"(.+?)\"',
		'<p class=\"date\">(.+?)</p>',
		'',
		''
	);");
$db->exec("INSERT INTO 'feed' (name, url, regex, note_regex, permalink_regex, date_regex, title_regex, prev_regex) VALUES
	('Poorly Drawn Lines',
		'http://poorlydrawnlines.com',
		'<img.+?size-full.+?src=\"(.+?)\"',
		'',
		'http://reddit.com/submit\?url=(.+?)&',
		'',
		'http://reddit.com/submit\?url=.+?&amp;title=(.+?)\"',
		''
	);");



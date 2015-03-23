----
-- phpLiteAdmin database dump (http://phpliteadmin.googlecode.com)
-- phpLiteAdmin version: 1.9.5
-- Exported: 3:33pm on February 12, 2015 (EST)
-- database file: ./cmx.sqlite
----
BEGIN TRANSACTION;

----
-- Table structure for comic
----
DROP TABLE 'comic';
CREATE TABLE 'comic' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'feed_id' INTEGER, 'permalink' TEXT, 'image' TEXT,'note' TEXT, 'title' TEXT, 'prev' TEXT, 'date' DATETIME, 'read' BOOLEAN DEFAULT 0);

----
-- Table structure for feed
----
DROP TABLE 'feed';
CREATE TABLE 'feed' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'url' TEXT, 'url_regex' TEXT, 'name' TEXT, 'regex' TEXT, 'note_regex' TEXT, 'permalink_regex' TEXT, 'comicid_regex' TEXT, 'date_regex' TEXT, 'title_regex' TEXT, 'prev_regex' TEXT);

----
-- Data dump for feed, a total of 25 rows
----
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('1','http://www.penny-arcade.com/comic',NULL,'Penny Arcade','id="comicFrame".+?src="(.+?)"','','property="og:url" content="(.+?)"',NULL,'<a href=".+?post/([/0-9]*).+?".+?Read News Post','<title>.+?- (.+?)</title>','btn btnPrev" href="(.+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('2','http://bearmageddon.com',NULL,'Bearmageddon','class="comicpane".+?src="(.+?)"','class="comicpane".+?title="(.+?)"','class="post-title".+?href="(.+?)"',NULL,'Last Update: (.+?) //','<title>.+?- (.+?)</title>','href="([^"]+?)" class="navi navi-prev"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('3','http://www.cad-comic.com/cad/',NULL,'Ctrl+Alt+Del','src="(.+?comics/cad.+?)"','','addthis:url="(.+?)"',NULL,'<title>.+?\((.+?)\)</title>','img src=".+?comics/cad.+?" alt="(.+?)"','href="/cad/([^"]+?)" class="nav-back"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('4','http://www.loadingartist.com/latest/',NULL,'Loading Artist','class="comic".+?src="(.+?)"','article id="post.+?comic type-comic.+?class="body">(.+?)</div>','property="og:url".+?content="(.+?)"',NULL,'<span class="date">(.+?)</span>','property="og:title".+?content="(.+?)"','ir-prev" href="(.+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('5','http://bradcolbow.com/','"comicicon-main".+?href="(.+?)"','The Brads','class="entry".+?src="(.+?)"',NULL,'',NULL,'class="post".+?<h5>(.+?)</h5>','class="post".+?<h2>(.+?)</h2>','"prev".+?href="(.+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('6','http://hijinksensue.com','<a href="([^"]+?)">Latest HijiNKS ENSUE</a>','HijiNKS ENSUE','id="comic".+?src="(.+?)"','id="comic".+?alt="(.+?)"','<h2 class="post-title"><a href="(.+?)"',NULL,'<span class="post-date">(.+?)</span>','<h2 class="post-title"><a.+?>(.+?)</a>','href="([^"]+?)" class="navi navi-prev-in"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('7','http://www.girlswithslingshots.com/',NULL,'Girls With Slingshots','id="comicbody".+?src=".+?\.\./(.+?)"','id="comicbody".+?title="(.+?)"',NULL,'id="comicbody".+?src=".+?GWS(\d*)|"http://www.girlswithslingshots.com/comic/gws-" . (\1) . "/"','class="cc-publishtime">posted (.+?) at','<title>.+?- (.+?)</title>','href="([^"]+?)" class="prev"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('8','http://evil-inc.com',NULL,'Evil Inc','id="comic".+?src="(.+?)\?.+?"','','td class="comic-nav"><a href="([^"]+?)/\#comments"',NULL,'id="comic".+?src=".+?(\d\d\d\d\d\d\d\d+?).+?\?.+?"','class="post-title">(.+?)</h2>','class="mininav-prev".+?href="(.+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('9','http://pvponline.com/comic/',NULL,'PvPonline','class="comic-art".+?src="(.+?)"','','http://www.facebook.com/sharer.php\?u=(.+?)\&',NULL,'class="comic-date.+?>(.+?)</div>','<title>PVP - (.+?)</title>','href="/comic/([^"]+?)".+?Prev');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('10','http://marryme.keenspot.com',NULL,'Marry Me','class="ksc".+?src="(.+?)"','','rel="canonical" href="(.+?)" />',NULL,'rel="canonical" href="http://marryme.keenspot.com/d/(.+?).html" />','','href="([^"]+?)" rel="prev"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('11','http://www.vgcats.com/comics/',NULL,'VG Cats','src="archives.gif".+?src="(.+?)"','',NULL,'href="\?strip_id=(\d+?)"><img src="back.gif"|"?strip_id=" . (\1+1)','src="archives.gif".+?src="images/(.+?)\.jpg"','<title>.+?- (.+?)</title>','<a href="([^"]+?)"><img src="back.gif"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('12','http://www.qwantz.com/index.php',NULL,'Dinosaur Comics','<img src="([^"]+?)" class="comic"','class="rss-title">(.+?)</span>','property="og:url" content="(.+?)"',NULL,'<title>Dinosaur Comics - (.+?) - awesome fun times!</title>','','rel="prev" href="([^"]+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('13','http://www.questionablecontent.net',NULL,'QC','>Random<.+?src="(.+?)"','id="news">(.+?)<center','','>Random<.+?src="http://www.questionablecontent.net/comics/(.+?).png"|"http://www.questionablecontent.net/view.php?comic=" . \1','id="news">.+?<b>(.+?)</b>','','<a href="([^"]+?)">Previous</a>');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('14','http://www.pandalikes.com/','<p>eng</p>.+?<p><a href=\"(.+?)\"','PANDALIKES','<div class=\"entry-attachment\">.+?<img src=\"(.+?)\"','<div','<g:plusone.+?href="(.+?)"',NULL,'/','<div class=\"entry-attachment\">.+?<img.+? title=\"(.+?)\"','href=''([^'']+?)''[^>]+?>PREVIOUS');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('15','http://tragedyseries.tumblr.com/','<p class="info".+?<a href="([^"]+?)"','Tragedy Series','<li class="posts".+?img src="(.+?)"','<p class="tags">(.+?)</p>','<p class="info".+?<a href="([^"]+?)"',NULL,'<p class="info".+?<a.+?>Posted on (.+?)</a>','','<div class="older"><a href="([^"]+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('16','http://harkavagrant.com/',NULL,'Hark, A Vagrant!','class="rss-content".+?<img src="(.+?)"','div class="black11.+?class="rss-content">(.+?)</span>','href="([^"]+?)"[^"]+?"buttonnext.png',NULL,'','class="rss-content".+?<img.+?title="(.+?)"','href="([^"]+?)"[^"]+?"buttonprevious.png');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('17','http://garfieldminusgarfield.net/','<div class="photo".+?a href="(.+?)"','garfield minus garfield','<div class="photo".+?img src="(.+?)"','<p class="caption">(.+?)</p>','<div class="photo".+?a href="(.+?)"',NULL,'<a href="/day/.+?">(.+?)</a>','<div class="photo".+?a href="http://garfieldminusgarfield.net/post/\d*/(.+?)"','href="([^"]+?)" id="previous"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('18','http://reallifecomics.com',NULL,'Real Life Comics','<div id="comic".+?img src="(.+?)"','','class="twitter-share-button" data-url="(.+?)"',NULL,'<div id="comic".+?img.+?alt="(.+?)"','','href="([^"]+?)" class="comic-nav-previous"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('19','http://helpusgreatwarrior.tumblr.com/','<div class="photo".+?a href="(.+?)"','Help Us Great Warrior!','<div class="photo".+?img src="(.+?)"','<div class="caption">(.+?)</div>','<div class="photo".+?a href="(.+?)"',NULL,'<a title="link to this post".+?>(.+?)</a>','','<a href="([^"]+?)">prev</a>');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('20','http://www.sinfest.net/',NULL,'Sinfest','<img src="(btphp/comics/.+?.gif)"','',NULL,'<img src="btphp/comics/(.+?).gif"|"http://www.sinfest.net/view.php?date=" . (\1)','<nobr>(.+?): </nobr>','<img src="btphp/comics/.+?alt="(.+?)">','href="([^"]+?)">\s+?<img.+?src="../images/prev.gif"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('21','http://basicinstructions.net/',NULL,'Basic Instructions','class="body".+?img src="/(.+?)\?','<div class="body">.+?<img[^>]+?></span></span></p>(.+?)</div>','<a class="permalink" href="/(.+?)">',NULL,'class="posted-on.+?<img.+?>(.+?)</span>','<title>Basic Instructions - Basic Instructions - (.+?)</title>','<a class="journal-entry-navigation-next" href="(.+?)">');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('22','http://www.xkcd.com/',NULL,'XKCD','id="comic".+?src="(.+?)"','id="comic".+?title="(.+?)"','Permanent link to this comic: (.+?)<',NULL,NULL,'<title>(.+?)</title>','rel="prev" href="/([^"]+?)"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('23','http://nonadventures.com',NULL,'The Non-Adventures of Wonderella','id="comic".+?img src="(.+?)"','id="comic".+?img.+?title="(.+?)"','<h2>.+?<a href="(.+?)" rel="bookmark"',NULL,'data-datetime="(.+?)T.+?"','id="comic".+?img.+?alt="(.+?)"','href="([^"]+?)" rel="prev"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('24','http://www.smbc-comics.com',NULL,'SMBC','id="comicimage".+?src=''(.+?)''','<p class="blogtext">(.+?)</p>','data-url="(.+?)"',NULL,'<p class="date">(.+?)</p>','','href="([^"]+?)"[^>]+?class="backRollover"');
INSERT INTO "feed" ("id","url","url_regex","name","regex","note_regex","permalink_regex","comicid_regex","date_regex","title_regex","prev_regex") VALUES ('25','http://poorlydrawnlines.com',NULL,'Poorly Drawn Lines','<img.+?size-full.+?src="(.+?)"','','http://reddit.com/submit\?url=(.+?)&',NULL,'','http://reddit.com/submit\?url=.+?&amp;title=(.+?)"','href="([^"]+?)" rel="prev"');
COMMIT;
<?php
/**
 * @author     Dennis Rogers <dennis@drogers.net>
 * @address    www.drogers.net
 * @date       3/23/15
 */
?>
<?php require('includes/header.php'); ?>
	<script>
		$( document ).on( "pageinit", "[data-role='page'].page-cmx", function() {
			var page = "#" + $( this ).attr( "id" ),
				// Get the filename of the next page that we stored in the data-next attribute
				next = $( this ).jqmData( "next" ),
				// Get the filename of the previous page that we stored in the data-prev attribute
				prev = $( this ).jqmData( "prev" );
			
			// Check if we did set the data-next attribute
			if ( next ) {
				// Prefetch the next page
				$.mobile.loadPage( next );
				// Navigate to next page on swipe left
				$( document ).on( "swipeleft", page, function() {
					changePage( next );
				});
				// Navigate to next page when the "next" button is clicked
				$( ".control .next", page ).on( "click", function() {
					changePage( next );
				});
			}
			// Disable the "next" button if there is no next page
			else {
				$( ".control .next", page ).addClass( "ui-disabled" );
			}
			// The same for the previous page (we set data-dom-cache="true" so there is no need to prefetch)
			if ( prev ) {
				$( document ).on( "swiperight", page, function() {
					changePage( prev, { reverse: true } );
				});
				$( ".control .prev", page ).on( "click", function() {
					changePage( prev, { reverse: true } );
				});
			}
			else {
				$( ".control .prev", page ).addClass( "ui-disabled" );
			}
			fullHeightContent();
		});
		$(document).on("pageshow", function(prevPage){
    		$.ajax(prevPage.currentTarget.URL.replace('view.php', 'markread.php'));
		});
		$(window).on("resize", fullHeightContent);
		$(window).on("orientationchange", fullHeightContent);
		$(document).on("pagecontainertransition", fullHeightContent);
		function fullHeightContent(){
			var screen = $.mobile.getScreenHeight(),
                header = $(".ui-header").hasClass("ui-header-fixed") ? $(".ui-header").outerHeight() - 1 : $(".ui-header").outerHeight(),
                contentCurrent = $(".ui-content").outerHeight() - $(".ui-content").height(),
                content = screen - header - contentCurrent;
            $(".ui-content").height(content-10);
            if($(window).width() > 1024) {
                $('.cmx-image img').css({'max-width': $(window).width()*.8, 'width':'auto'});
            } else {
                $('.cmx-image img').css({'width': $(window).width()-20, 'max-width':'auto'});
            }
		}
		function changePage(url, data){
    		if(data == undefined) data = {};
            if(url == '<?php echo $cmx->baseUrl ?>')
                data.reloadPage = 1;
    		$.mobile.changePage(url, data);
		}
    </script>
<?php
        
$url = $_GET['url'] ? $_GET['url'] : file_get_contents('catchup');
file_put_contents('catchup', $url);
$parts = explode('/', $url);
array_pop($parts);
$id = array_pop($parts);

$imgReg = 'class="comicpane"><img src="(.+?)"';
$nextReg = 'href="(.+?)" class="navi navi-next"';
$prevReg = 'href="(.+?)" class="navi navi-prev"';

$pageHtml = $cmx->getPage($url);

preg_match("#$imgReg#", $pageHtml, $img);
$img = $img[1];
$parts = explode('-', basename($img));
array_pop($parts);
$date = implode('-', $parts);

preg_match("#$nextReg#", $pageHtml, $next);
$next = '?url=' . $next[1];

preg_match("#$prevReg#", $pageHtml, $prev);
$prev = '?url=' . $prev[1];
?>
<div data-role="page" id="<?php echo $id ?>" data-theme="b" class="page-cmx" data-dom-cache="true" data-next="<?php echo $next ?>" data-prev="<?php echo $prev ?>">

    <div data-role="header" data-fullscreen="true" data-id="hdr" data-toggle="false">
        <a href="http://cmx.drogers.net/catchup.php" data-role="button">Last</a>
		<h1><a href="<?php echo $url ?>">Permalink</a></h1>
		<div data-role="controlgroup" class="control ui-btn-right" data-type="horizontal" data-mini="true">
        	<a href="#" class="prev" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="d">Previous</a>
        	<a href="#" class="next" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="d">Next</a>
        </div>
	</div><!-- /header -->

	<div data-role="content" class="cmx-image">
    	<img src='<?php echo $img ?>' />
    	<p><?php echo date("l, M jS, Y", strtotime($date)) ?></p>
	</div><!-- /content -->
	
</div><!-- /page -->
<?php require('includes/footer.php'); ?>







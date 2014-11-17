<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
?>
	<script>
		$( document ).on( "pageinit", "[data-role='page'].page-cmx", function() {
			var page = "#" + $( this ).attr( "id" ),
				// Get the filename of the next page that we stored in the data-next attribute
				next = $( this ).jqmData( "next" ),
				// Get the filename of the previous page that we stored in the data-prev attribute
				prev = $( this ).jqmData( "prev" );
			
			// Check if we did set the data-next attribute
			console.log(next + " - " + prev);
			if ( next ) {
				// Prefetch the next page
				$.mobile.loadPage( next );
				// Navigate to next page on swipe left
				$( document ).on( "swipeleft", page, function() {
					$.mobile.changePage( next );
				});
				// Navigate to next page when the "next" button is clicked
				$( ".control .next", page ).on( "click", function() {
					$.mobile.changePage( next );
				});
			}
			// Disable the "next" button if there is no next page
			else {
				$( ".control .next", page ).addClass( "ui-disabled" );
			}
			// The same for the previous page (we set data-dom-cache="true" so there is no need to prefetch)
			if ( prev ) {
				$( document ).on( "swiperight", page, function() {
					$.mobile.changePage( prev, { reverse: true } );
				});
				$( ".control .prev", page ).on( "click", function() {
					$.mobile.changePage( prev, { reverse: true } );
				});
			}
			else {
				$( ".control .prev", page ).addClass( "ui-disabled" );
			}
			fullHeightContent();
		});
		$(window).on("resize", fullHeightContent);
		$(window).on("orientationchange", fullHeightContent);
		$(document).on("pagecontainertransition", fullHeightContent);
		function fullHeightContent(){
			var screen = $.mobile.getScreenHeight(),
                header = $(".ui-header").hasClass("ui-header-fixed") ? $(".ui-header").outerHeight() - 1 : $(".ui-header").outerHeight(),
                footer = $(".ui-footer").hasClass("ui-footer-fixed") ? $(".ui-footer").outerHeight() - 1 : $(".ui-footer").outerHeight(),
                contentCurrent = $(".ui-content").outerHeight() - $(".ui-content").height(),
                content = screen - header - footer - contentCurrent;
            $(".ui-content").height(content-10);
            if($(window).width() > 700) {
                $('.cmx-image img').css('max-height', content-20);
            } else {
                $('.cmx-image img').css('width', $(window).width()-20);
            }
		}
    </script>	
<?php 
$feedId = (int)$_GET['feed'];
$comicId = (int)$_GET['comic'];
$comics = $cmx->getUnreadFeedComics($feedId);
$comic = $comics[$comicId];
?>
<div data-role="page" id="comic_<?php echo $comicId ?>" data-theme="b" class="page-cmx" data-dom-cache="true" <?php if(!empty($comics[$comicId+1])): ?> data-next="view.php?feed=<?php echo $feedId ?>&comic=<?php echo $comicId+1 ?>"<?php endif; ?><?php if(!empty($comics[$comicId-1])): ?> data-prev="view.php?feed=<?php echo $feedId ?>&comic=<?php echo $comicId-1 ?>"<?php endif; ?>>

    <div data-role="header" data-position="fixed" data-fullscreen="true" data-id="hdr" data-toggle="true" data-visible-on-page-show="false">
		<h1><a href="<?php echo $comic->permalink ?>"><?php echo $comic->title ?></a></h1>
        <a href="<?php echo $cmx->baseUrl ?>" data-role="button">Back</a>
	</div><!-- /header -->

	<div data-role="content" class="cmx-image">
    	<img src='<?php echo $comic->image ?>' />
    	<p><?php echo $comic->note ?></p>
	</div><!-- /content -->

    <div data-role="footer" data-position="fixed" data-fullscreen="true" data-id="ftr" data-toggle="true" data-visible-on-page-show="false">
		<div data-role="controlgroup" class="control ui-btn-right" data-type="horizontal" data-mini="true">
        	<a href="#" class="prev" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="d">Previous</a>
        	<a href="#" class="next" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="d">Next</a>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->
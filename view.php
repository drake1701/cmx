<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page Title</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css" />
	<link rel="stylesheet" href="../assets/css/jqm-demos.css">
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../assets/js/custom-init.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>
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
            $(".ui-content").height(content-40);
		}
    </script>	
    <style>
        .page-cmx {
            background-color:#555;
        }
        .cmx-image {
            margin:20px;
			background-size: contain;
			background-position: center center;
			background-repeat: no-repeat;
        }
		.ui-footer {
			background: none;
			border: none;
		}        
		.control.ui-btn-right {
			top: auto;
			bottom: 7px;
			margin: 0;
		}    
		.ui-header, .ui-title, .control .ui-btn {
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			-o-user-select: none;
			user-select: none;
		}		    
    </style>
</head>
<body>
<?php 
$images = array(
    "images/sara-jean-underwood-lv.jpg",
    "images/sara-jean-underwood-lvi.jpg",
    "images/sara-jean-underwood-lx.jpg",
    "images/sara-jean-underwood-lxii.jpg"   
);
$i = (int)$_GET['i'];
$page = pathinfo($images[$i]);
?>
<div data-role="page" id="<?php echo $page['filename'] ?>" data-theme="a" class="page-cmx" data-dom-cache="true" <?php if(!empty($images[$i+1])): ?> data-next="index.php?i=<?php echo $i+1 ?>"<?php endif; ?><?php if(!empty($images[$i-1])): ?> data-prev="index.php?i=<?php echo $i-1 ?>"<?php endif; ?>>

    <div data-role="header" data-position="fixed" data-fullscreen="true" data-id="hdr" data-tap-toggle="true" data-visible-on-page-show="false">
		<h1><?php echo $page['filename'] ?></h1>
	</div><!-- /header -->

	<div data-role="content" class="cmx-image" style="background-image: url('<?php echo $images[$i] ?>')">
	</div><!-- /content -->

    <div data-role="footer" data-position="fixed" data-fullscreen="true" data-id="ftr" data-tap-toggle="false">
		<div data-role="controlgroup" class="control ui-btn-right" data-type="horizontal" data-mini="true">
        	<a href="#" class="prev" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="d">Previous</a>
        	<a href="#" class="next" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="d">Next</a>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->

</body>
</html>
<?php
/**
 * Template Name: Page : Contact Template with No Sidebar
 *
 * The include file used for Contact Page.
 *
 * @package	 WordPress
 * @subpackage 	Avis
 * @version 	1.0.0
 *
*/
get_header();  
global $post, $avis_shortname; 
?>	
<?php
	$_contact_google_map 		   	= get_post_meta($post->ID,'_contact_google_map',true);
	$_contact_gmap_apikey 		   	= get_post_meta($post->ID,'_contact_gmap_apikey',true);
	$_contact_gmap_height 		   	= get_post_meta($post->ID,'_contact_gmap_height',true);
	$_contact_map_overlay_content   = get_post_meta($post->ID,'_contact_map_overlay_content',true);
	$_contact_view_map_title   		= get_post_meta($post->ID,'_contact_view_map_title',true);
	$avis_gmap_lat		 		= get_post_meta($post->ID,'_contact_gmap_lat',true);
	$avis_gmap_long				= get_post_meta($post->ID,'_contact_gmap_long',true);
	$avis_gmap_infiotxt			= get_post_meta($post->ID,'_contact_gmap_infotxt',true);
	$avis_gmap_infost	  		= get_post_meta($post->ID,'_contact_gmap_infost',true);
	$avis_gmap_iconimg	 		= get_post_meta($post->ID,'_contact_gmap_iconimg',true);
	$avis_gmap_markani	 		= get_post_meta($post->ID,'_contact_gmap_markanim',true);
	$avis_gmap_zlevel	  		= get_post_meta($post->ID,'_contact_gmap_zlevel',true);
	$avis_gmap_maptype	 		= get_post_meta($post->ID,'_contact_gmap_maptype',true);
	$avis_gmap_infiotxt			= ($avis_gmap_infiotxt) ? $avis_gmap_infiotxt : 'This Is Indore.';
	$avis_gmap_iconimg	 		= ($avis_gmap_iconimg) ? $avis_gmap_iconimg : 0;
?>

<input type="hidden" id="avis-gmap-content" value="<?php echo $avis_gmap_infiotxt; ?>" />

<?php if($avis_gmap_lat && $avis_gmap_long){ ?>

	<?php if( isset($_contact_gmap_apikey) && $_contact_gmap_apikey != '' ){ ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_contact_gmap_apikey; ?>&amp;v=3"></script>
	<?php } else { ?>
		<script src="https://maps.googleapis.com/maps/api/js"></script>
	<?php } ?>
	<script type="text/javascript">
	
	var marker;
	var map;
	var ele;
	jQuery(document).ready(function() {
		ele = "";
		var contstring = jQuery('#avis-gmap-content').val();	
		var lines = contstring.split(/\n/g);	  
		for(var i=0; i < lines.length; i++) {	  
			 ele += lines[i];				  
		}
	});

	function sktinitializemap() 
	{
		var contentStringEle = ele;
		var contentString = contentStringEle; 
		var image = '<?php echo $avis_gmap_iconimg; ?>';
		var infowindow = new google.maps.InfoWindow({content: contentString,maxWidth: 300}); // info-window text
		var myLatLng = new google.maps.LatLng('<?php echo $avis_gmap_lat; ?>','<?php echo $avis_gmap_long; ?>'); // address in the form of latitude/lognitude

		var mapOptions = {
			zoom: <?php echo $avis_gmap_zlevel; ?>,
			scrollwheel: false,
			center: myLatLng,
			mapTypeControl: true,
			panControl: true,
			mapTypeControlOptions: {
			  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
			},
			zoomControl: true,
			zoomControlOptions: {
			  style: google.maps.ZoomControlStyle.LARGE
			},
			mapTypeId: google.maps.MapTypeId.<?php echo $avis_gmap_maptype; ?>
		}

		map = new google.maps.Map(document.getElementById('map'),mapOptions);
		// add google map marker
		marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			icon: image,
			animation: google.maps.Animation.<?php echo $avis_gmap_markani; ?>
		});

		// open info-window at marker click event
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});

		// check info-window status
		<?php if($avis_gmap_infost ==="open") { ?>
			infowindow.open(map,marker);
			avis_moveMap(avis_moveMap, 10);
		<?php } ?>
	}

	function avis_moveMap() {
		map.panBy(0, -100);
	}

	// initialize the map at window load event
	google.maps.event.addDomListener(window, 'load', sktinitializemap);
	</script>  
	
	<style>
		#map_canvas #map, #map_canvas {
			height: <?php if(isset($_contact_gmap_height) && $_contact_gmap_height !=""){ echo $_contact_gmap_height; }else{ echo'480'; } ?>px;
		}
	</style>
			
<?php } ?>
<div id="contact-page">
	<div id="content">
		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>">		
			<div class="contact-page-content">
				<div class="container">
					<div class="row-fluid">
						<div class="contact-post skepost">
							<?php the_content(); ?>
							<?php wp_link_pages(__('<p><strong>Pages:</strong> ','avis'), '</p>', __('number','avis')); ?>
							<?php edit_post_link('Edit', '', ''); ?>	
						</div><!-- skepost --> 
					</div>
				</div>
			</div>
			<?php if($_contact_google_map == 'on'){ ?>

			<div id="map_canvas" class="google-map">
			
				<!-- GOOGLE MAP  -->
					<?php if($avis_gmap_lat && $avis_gmap_long){ ?><div id="map"></div><div class="gmap-close"></div><?php } ?>
				<!-- GOOGLE MAP  -->

				<div class="contact-map-overlay ">
					<?php if (isset($_contact_map_overlay_content) && $_contact_map_overlay_content !='' ) { echo $_contact_map_overlay_content; } ?>

					<div class="full_map clearfix">
						<a href="javascript:void(0)" id="contact-gmap-toggle" title="Hide/Show Map">
							<?php if (isset($_contact_view_map_title) && $_contact_view_map_title !='' ) { echo $_contact_view_map_title; } else { _e('VIEW MAP','avis'); } ?>
						</a>
					</div>

				</div>
				
			</div>

			<?php } ?>

		</div>
		<!-- post -->
		<?php endwhile; ?>
		<?php else :  ?>
		<div class="post">
			<div class="container">
				<div class="row-fluid">
					<h2><?php _e('Not Found','avis'); ?></h2>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div><!-- content --> 
</div><!-- contact-page -->

<?php get_footer(); ?>
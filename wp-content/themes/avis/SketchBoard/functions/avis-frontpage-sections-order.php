<?php
/*-----------------------------------------------------------------------------------*/
/* ADD FRONTPAGE SECTION METABOXES
/*-----------------------------------------------------------------------------------*/
// ADD METABOX

add_action('admin_init', 'avis_frontpagesection_metabox');
function avis_frontpagesection_metabox(){
	add_meta_box('avis-fpage-sections-order-metaboxes', 'Avis : Home Page Sections Order', 'avis_frontpagesection_metabox_callback', 'page', 'normal', 'high');
}

// METABOX CALLBACK
function avis_frontpagesection_metabox_callback() { 
	global $post;
	$_avis_frontpage_sections_order = get_post_meta( $post->ID,'_avis_frontpage_sections_order',true );
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<ul id="avis-frontpage-sections">
	<?php 
	if(isset($_avis_frontpage_sections_order) && $_avis_frontpage_sections_order !="") {
		$_avis_frontpage_sections_order = $_avis_frontpage_sections_order;
	}else{
		$_avis_frontpage_sections_order = array('Featured Box Section','About Section','Latest Project Section','Testimonial Section','Call To Action Section','Services Section','Team Member Section','Twitter Section','Our Brands Section','Page Content');
	}
	foreach($_avis_frontpage_sections_order as $fsection){ 
		?>
			<li><input type="text" value="<?php echo $fsection; ?>" name="_avis_frontpage_sections_order[]" readonly="readonly" /></li>
		<?php 
	} 	
	?>
</ul>

<?php 
} 

// Action when save post
add_action('save_post', 'avis_admin_save_frontpagesection');

/* When the post is saved, saves our custom data */
function avis_admin_save_frontpagesection( $post_id ) {

	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	// Check permissions
	if(isset($_POST['post_type'])){
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		}
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// OK, we're authenticated: we need to find and save the data
	if(isset($_POST['_avis_frontpage_sections_order'])){ 
		$_avis_frontpage_sections_order = $_POST['_avis_frontpage_sections_order']; 

		foreach($_avis_frontpage_sections_order as $fsection){
			$orderSection[] = $fsection;
		}
	}
	
	global $post;
	if(isset($_avis_frontpage_sections_order)){ update_post_meta($post->ID, '_avis_frontpage_sections_order', $orderSection); }
	
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
}
?>
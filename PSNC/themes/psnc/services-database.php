<?php
/*
This file deals with the custom meta data for the 'our-services' custom post type (Services Database). 
1. Insert the meta boxes
2. Define the function of each meta box
3. Save the data 
*/


/* 

1. Insert the meta boxes
=====================

*/

function add_sd_meta_boxes() {
    // Service ID
    add_meta_box(
		'parent_service_id', // $id
		'Service ID', // $title 
		'service_id_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority    
    // Description
    add_meta_box(
		'parent_service_description', // $id
		'Description', // $title 
		'service_description_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
    // Location of service
    add_meta_box(
		'parent_location_of_service', // $id
		'Location of Service', // $title 
		'location_of_service_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Commissioner
    add_meta_box(
		'parent_service_commissioner', // $id
		'Commissioner', // $title 
		'service_commissioner_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Method of commissioning
    add_meta_box(
		'parent_method_of_commissioning_service', // $id
		'Method of commissioning', // $title 
		'method_of_commissioning_service_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Source of funding
    add_meta_box(
		'parent_service_source_of_funding', // $id
		'Source of funding', // $title 
		'service_source_of_funding_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Service type
    add_meta_box(
		'parent_service_type', // $id
		'Service type', // $title 
		'service_type_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Service fee
    add_meta_box(
		'parent_service_fee', // $id
		'Fee (&pound;)', // $title 
		'service_fee_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Other organisations
    add_meta_box(
		'parent_service_other_organisations', // $id
		'Other organisations', // $title 
		'service_other_organisations_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Dates
    add_meta_box(
		'parent_service_dates', // $id
		'Dates', // $title 
		'service_dates_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Status
    add_meta_box(
		'parent_service_status', // $id
		'Status', // $title 
		'service_status_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Training
    add_meta_box(
		'parent_service_training', // $id
		'Training', // $title 
		'service_training_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority	
	// Comment
    add_meta_box(
		'parent_service_comment', // $id
		'Comments', // $title 
		'service_comment_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Contact
    add_meta_box(
		'parent_service_contact', // $id
		'Contact', // $title 
		'service_contact_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Evaluation/Evidence
    add_meta_box(
		'parent_service_evaluation', // $id
		'Evidence', // $title 
		'service_evaluation_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority
	// Service docs meta box
    /*add_meta_box(
		'parent_service_docs', // $id
		'Documents', // $title 
		'service_docs_meta_box', // $callback
		'our-services', // $page
		'normal', // $context
		'default'); // $priority*/
	// Service docs side meta box
    add_meta_box(
		'parent_service_docs_side', // $id
		'Attached documents', // $title 
		'service_docs_side_meta_box', // $callback
		'our-services', // $page
		'side', // $context
		'default'); // $priority
}
add_action('add_meta_boxes', 'add_sd_meta_boxes');

/* 

2. Define the functions
=====================

*/

// Service ID

function service_id_meta_box($post) { ?>
	<p>
		<?php 
		   echo $post->ID;
		?>
	</p>
	<?php	
}

// description
function service_description_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_description = html_entity_decode(isset( $values['service_description'] ) ? esc_attr( $values['service_description'][0] ) : '');
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<?php 
		$service_editor_options = array('media_buttons' => false, 'teeny' => false);
 
		wp_editor( $service_description, 'service_description', $service_editor_options );
		?>
	</p>
	<?php	
}

// location
function location_of_service_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'location-of-service', array("fields" => "ids"));
	$location_of_service = isset( $values['location_of_service'] ) ? esc_attr( $values['location_of_service'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="location_of_service" id="location_of_service">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'location-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<?php	
}

//commissioner
function service_commissioner_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'service-commissioner', array("fields" => "ids"));
	$service_commissioner = isset( $values['service_commissioner'] ) ? esc_attr( $values['service_commissioner'][0] ) : '';
	$values = get_post_custom( $post->ID );
	$other_commissioner = isset( $values['other_commissioner'] ) ? esc_attr( $values['other_commissioner'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="service_commissioner" id="service_commissioner">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'service-commissioner', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<p>
		<label for="other_commissioner">If 'Other', please add here:</label>
		<input type="text" id="other_commissioner" name="other_commissioner" value="<?php echo $other_commissioner; ?>">
	</p>
	<?php	
}

//method of commissioning
function method_of_commissioning_service_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'method-of-commissioning', array("fields" => "ids"));
	$method_of_commissioning = isset( $values['method_of_commissioning'] ) ? esc_attr( $values['method_of_commissioning'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="method_of_commissioning" id="method_of_commissioning">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'method-of-commissioning', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<?php	
}

// source of funding
function service_source_of_funding_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'funding-source', array("fields" => "ids"));
	$source_of_funding = isset( $values['source_of_funding'] ) ? esc_attr( $values['source_of_funding'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="source_of_funding" id="source_of_funding">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'funding-source', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<?php	
}

// service type
function service_type_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'type-of-service', array("fields" => "ids"));
	$service_type = isset( $values['service_type'] ) ? esc_attr( $values['service_type'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="service_type" id="service_type">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'type-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<?php	
}

// service fee
function service_fee_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_fee = isset( $values['service_fee'] ) ? esc_attr( $values['service_fee'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<input type="text" id="service_fee" name="service_fee" value="<?php echo $service_fee; ?>">
	</p>
	<?php	
}

// other organisations involved
function service_other_organisations_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_other_organisations = isset( $values['service_other_organisations'] ) ? esc_attr( $values['service_other_organisations'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<textarea id="service_other_organisations" name="service_other_organisations" style="width:100%;"><?php echo $service_other_organisations; ?></textarea>
	</p>
	<?php	
}

// date
function service_dates_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_date_start = isset( $values['service_date_start'] ) ? esc_attr( $values['service_date_start'][0] ) : '';
	$service_date_end = isset( $values['service_date_end'] ) ? esc_attr( $values['service_date_end'][0] ) : '';
	
	// check what format the date is in
	
	// if the date is in yyyy-mm-dd format (i.e. received from formidable)
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$service_date_start))
    {
    	// reformat the output to dd/mm/yy
        $formatted_start_date = date("d/m/Y", strtotime($service_date_start));
    }else{
        $formatted_start_date = $service_date_start;
    }
    
    // if the date is in yyyy-mm-dd format (i.e. received from formidable)
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$service_date_end))
    {
    	// reformat the output to dd/mm/yy
        $formatted_end_date = date("d/m/Y", strtotime($service_date_end));
    }else{
        $formatted_end_date = $service_date_end;
    }
	
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script>
	jQuery(function() { 
		jQuery( ".service_date_start" ).datepicker({dateFormat:'dd/mm/yy', showOn: "button", buttonImage: "/wp-content/themes/psnc/img/calendar.gif", buttonImageOnly: true, changeMonth: true, changeYear: true	});
		jQuery( ".service_date_end" ).datepicker({dateFormat:'dd/mm/yy', showOn: "button", buttonImage: "/wp-content/themes/psnc/img/calendar.gif", buttonImageOnly: true, changeMonth: true, changeYear: true	});  
	});
	</script>
	<table>
		<tr>
			<td>			
				<label for="service_date_start">Start date: </label>
				<input class="service_date_start" type="text" id="service_date_start" name="service_date_start" value="<?php echo $formatted_start_date; ?>">
			</td>
			<td style="width:20px;"></td>
			<td>
				<label for="service_date_end">End date: </label>
				<input class="service_date_end" type="text" id="service_date_end" name="service_date_end" value="<?php echo $formatted_end_date; ?>">
			</td>
		</tr>
	</table>
	<?php	
}

// status
function service_status_meta_box($post) {
	$term_list = wp_get_post_terms($post->ID, 'service-status', array("fields" => "ids"));
	$service_status = isset( $values['service_status'] ) ? esc_attr( $values['service_status'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<select name="service_status" id="service_status">
			<option value="">-- Select --</option>
			<?php 
			$args = array('taxonomy' => 'service-status', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
			$categories=get_categories($args); 
			foreach ($categories as $category) { ?>
				<option value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, $term_list)) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
			<?php } ?> 
		</select>
	</p>
	<?php	
}

// training
function service_training_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_training = html_entity_decode(isset( $values['service_training'] ) ? esc_attr( $values['service_training'][0] ) : '');
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<?php 
		$service_editor_options = array('media_buttons' => false, 'textarea_rows' => 5, 'teeny' => false);
		wp_editor( $service_training, 'service_training', $service_editor_options ); 
		?>
	<?php	
}

// comments
function service_comment_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_comment = isset( $values['service_comment'] ) ? esc_attr( $values['service_comment'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<textarea id="service_comment" name="service_comment" style="width:100%;"><?php echo $service_comment; ?></textarea>
	</p>
	<?php	
}

// contact
function service_contact_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_contact_name = isset( $values['service_contact_name'] ) ? esc_attr( $values['service_contact_name'][0] ) : '';
	$service_contact_email = isset( $values['service_contact_email'] ) ? esc_attr( $values['service_contact_email'][0] ) : '';
	$service_contact_tel = isset( $values['service_contact_tel'] ) ? esc_attr( $values['service_contact_tel'][0] ) : '';
	$service_contact_address = isset( $values['service_contact_address'] ) ? esc_attr( $values['service_contact_address'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<label for="service_contact_name">Name:</label><br>
		<input type="text" id="service_contact_name" name="service_contact_name" value="<?php echo $service_contact_name; ?>">
	</p>
	<p>
		<label for="service_contact_email">Email:</label><br>
		<input type="email" id="service_contact_email" name="service_contact_email" value="<?php echo $service_contact_email; ?>">
	</p>
	<p>
		<label for="service_contact_tel">Telephone number:</label><br>
		<input type="tel" id="service_contact_tel" name="service_contact_tel" value="<?php echo $service_contact_tel; ?>">
	</p>
	<p>
		<label for="service_contact_address">Address:</label><br>
		<textarea id="service_contact_address" name="service_contact_address" style="width:300px; height:100px;"><?php echo $service_contact_address; ?></textarea>
	</p>
	<?php	
}

//evaluation
function service_evaluation_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$service_evaluation = html_entity_decode(isset( $values['service_evaluation'] ) ? esc_attr( $values['service_evaluation'][0] ) : '');
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
		<?php 
		$service_editor_options = array('media_buttons' => false, 'textarea_rows' => 5, 'teeny' => false);
		wp_editor( $service_evaluation, 'service_evaluation', $service_editor_options ); 
		?>
	</p>
	<?php	
}

// docs
/*function service_docs_meta_box($post) {
	// get the values from formidable if they exist

	
	
	$values = get_post_custom( $post->ID );
	$service_docs .= html_entity_decode(isset( $values['service_docs'] ) ? esc_attr( $values['service_docs'][0] ) : '');
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>

		<?php 
		$service_editor_options = array('media_buttons' => false, 'textarea_rows' => 5, 'teeny' => false);
		wp_editor( $service_docs, 'service_docs', $service_editor_options ); 
		?>
		
		
<?php }*/

// docs sidebar
function service_docs_side_meta_box($post) {

		?>
		
		<?php 

		$args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' =>'any', 'post_parent' => $post->ID ); 
		$attachments = get_posts( $args );
		
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$the_link = wp_get_attachment_url( $attachment->ID);
				$att_title = $attachment->post_title;
				$att_id = $attachment->ID;
				echo '<p>';
				echo '<a href="'.$the_link.'" class="the_attachment">'.$att_title.'</a>';              
				echo '&nbsp;&nbsp;&nbsp;&nbsp;Remove file? <input type="checkbox" id="att_remove" name="check_list[]" class="display_checkbox" value="'.$att_id.'" />';
				echo '<input type="hidden" value="'.$att_id.'" id="attachment-'.$att_id.'" />';
				echo '</p>';
			}
			echo '<p><strong>Any files marked for deletion will be removed the next time this post is saved.</strong></p>';
		} else {
			echo '<p>No files have been uploaded.</p>';
		} ?>
		
		<?php
		
		function modify_form(){
		echo  '<script type="text/javascript">
		      jQuery("#post").attr("enctype", "multipart/form-data");
		        </script>
		  ';
		}
		add_action('admin_footer','modify_form');

		?>
		
		<div class="upload_service_docs">
			<div class="uploader">
				<!-- http://codestag.com/how-to-use-wordpress-3-5-media-uploader-in-theme-options/ requires a jQuery function located in js/admin.js -->
				
				<p>

				<input type="file" name="bijlage" id="bijlage"/>
				
				</p>
			  
			  
			</div>
		</div>
		
		
<?php }

/* 

3. Save all the values
=====================

*/


function services_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 'a' => array('href' => array()), 'ul' => array(), 'li' => array(), 'p' => array(), 'ol' => array());
	
	// Make sure your data is set before trying to save it
	if( isset( $_POST['service_id'] ) )
		update_post_meta( $post_id, 'service_id', $_POST['service_id'] );
	
	if( isset( $_POST['service_description'] ) )
		update_post_meta( $post_id, 'service_description', $_POST['service_description'] );
	
	if( isset( $_POST['location_of_service'] ) )
		wp_set_post_terms( $post_id, $_POST['location_of_service'], 'location-of-service', false );
	
	if( isset( $_POST['service_commissioner'] ) )
		wp_set_post_terms( $post_id, $_POST['service_commissioner'], 'service-commissioner', false );
		
	if( isset( $_POST['other_commissioner'] ) )
		update_post_meta( $post_id, 'other_commissioner', wp_kses( $_POST['other_commissioner'], $allowed ) );
		
	if( isset( $_POST['method_of_commissioning'] ) )
		wp_set_post_terms( $post_id, $_POST['method_of_commissioning'], 'method-of-commissioning', false );
		
	if( isset( $_POST['source_of_funding'] ) )
		wp_set_post_terms( $post_id, $_POST['source_of_funding'], 'funding-source', false );
		
	if( isset( $_POST['service_type'] ) )
		wp_set_post_terms( $post_id, $_POST['service_type'], 'type-of-service', false );
		
	if( isset( $_POST['service_fee'] ) )
		update_post_meta( $post_id, 'service_fee', wp_kses( $_POST['service_fee'], $allowed ) );
		
	if( isset( $_POST['service_other_organisations'] ) )
		update_post_meta( $post_id, 'service_other_organisations', wp_kses( $_POST['service_other_organisations'], $allowed ) );
		
	if( isset( $_POST['service_date_start'] ) )
		update_post_meta( $post_id, 'service_date_start', wp_kses( $_POST['service_date_start'], $allowed ) );
	
	if( isset( $_POST['service_date_end'] ) )
		update_post_meta( $post_id, 'service_date_end', wp_kses( $_POST['service_date_end'], $allowed ) );
		
	if( isset( $_POST['service_status'] ) )
		wp_set_post_terms( $post_id, $_POST['service_status'], 'service-status', false );
		
	if( isset( $_POST['service_training'] ) )
		update_post_meta( $post_id, 'service_training', $_POST['service_training'] );
		
	if( isset( $_POST['service_comment'] ) )
		update_post_meta( $post_id, 'service_comment', wp_kses( $_POST['service_comment'], $allowed ) );
		
	if( isset( $_POST['service_contact_name'] ) )
		update_post_meta( $post_id, 'service_contact_name', wp_kses( $_POST['service_contact_name'], $allowed ) );
		
	if( isset( $_POST['service_contact_email'] ) )
		update_post_meta( $post_id, 'service_contact_email', wp_kses( $_POST['service_contact_email'], $allowed ) );
		
	if( isset( $_POST['service_contact_tel'] ) )
		update_post_meta( $post_id, 'service_contact_tel', wp_kses( $_POST['service_contact_tel'], $allowed ) );
		
	if( isset( $_POST['service_contact_address'] ) )
		update_post_meta( $post_id, 'service_contact_address', wp_kses( $_POST['service_contact_address'], $allowed ) );
		
	/*if( isset( $_POST['service_docs'] ) )
		update_post_meta( $post_id, 'service_docs', $_POST['service_docs'] );*/
		
	if( isset( $_POST['service_evaluation'] ) )
		update_post_meta( $post_id, 'service_evaluation', $_POST['service_evaluation'] );
		
	// The two below are from the same taxonomy so we need to update them as an array so they are not overwritten
	
	if( isset( $_POST['service_commissioner'], $_POST['service_status'] ) )
		wp_set_post_terms( $post_id, array($_POST['service_status'], $_POST['service_commissioner']), 'our-services-category', false );
		
	// Check to see if any attachments need to be deleted
	
	if(!empty($_POST['check_list'])) {
    	foreach($_POST['check_list'] as $value) {
            wp_delete_attachment( $value );
        
    }

}

}
add_action( 'save_post', 'services_meta_box_save' );
?>
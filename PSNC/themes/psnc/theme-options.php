<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'sample_options', 'site_description', 'theme_options_validate' );
	register_setting( 'ga_options', 'ga_account', 'ga_validate' );
	add_filter('site_description', 'stripslashes');
}

/**
 * Load up the menu pages
 */
function theme_options_add_page() {	
	add_submenu_page('options-general.php', 'Site Description', 'Site Description', 'edit_theme_options', 'theme_options', 'theme_options_do_page'); 
	add_submenu_page('options-general.php', 'Google Analytics', 'Google Analytics', 'edit_theme_options', 'ga_options', 'ga_do_page'); 
}


/**
 * Site description options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>Site Description</h2>"; ?>


		<form method="post" action="options.php">
			<?php settings_fields( 'sample_options' ); ?>
			<?php $options = get_option( 'site_description' ); ?>

			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Enter a site description', 'psnc' ); ?></th>
					<td>

						<?php 
						$args = array(
						    'textarea_rows' => 15,
						    'teeny' => true,
						    'quicktags' => true,
						    'media_buttons' => false
						);
						 $saved_vals = $options['sometextarea'];
						wp_editor( stripslashes($saved_vals), 'site_description[sometextarea]', $args );
						submit_button( 'Save description' );
						?>
						<label class="description" for="site_description[sometextarea]"><?php _e( 'This will appear on your home page and also help with SEO (HTML allowed).', 'psnc' ); ?></label>
					</td>
				</tr>
			</table>

		</form>
	</div>
	<?php
	
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );



	return $input;
}



/**
 * GA options page
 */
function ga_do_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>Google Analytics</h2>"; ?>


		<form method="post" action="options.php">
			<?php settings_fields( 'ga_options' ); ?>
			<?php $options = get_option( 'ga_account' ); ?>

			<table class="form-table">

				<?php
				/**
				 * A sample text input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Add your Google Analytics web-property ID here. <a href="https://support.google.com/analytics/answer/1032385?hl=en-GB" target="_blank">How can I find this?</a>', 'psnc' ); ?></th>
					<td>
						<input id="ga_account[ga_id]" class="regular-text" type="text" name="ga_account[ga_id]" value="<?php esc_attr_e( $options['ga_id'] ); ?>" />
						<label class="description" for="ga_account[ga_id]"><?php _e( 'UA-XXXXX-Y or UA-XXXXX-YY', 'psnc' ); ?></label>
					</td>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'psnc' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function ga_validate( $input ) {

	// Say our text option must be safe text with no HTML tags
	$input['ga_id'] = wp_filter_nohtml_kses( $input['ga_id'] );

	return $input;
}

/*
Create a network output shortcode
*/
function listnetwork_function() {
  global $wpdb;
			
		// Query all blogs from multi-site install
		$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 ORDER BY path");
	
		// Start unordered list
		echo '<ul>';
	
		// For each blog search for blog name in respective options table
		foreach( $blogs as $blog ) {
	
			// Query for name from options table
			$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
			foreach( $blogname as $name ) { 
	
				// Create bullet with name linked to blog home pag
				echo '<li>';
				echo $name->option_value;
				echo '<a href="http://';
				echo $blog->domain;
				echo $blog -> path;
				echo '">';
				echo ' Visit';
				echo '</a> or ';
				echo '<a href="http://';
				echo $blog->domain;
				echo $blog -> path;
				echo '/wp-admin">';
				echo 'Edit';
				echo '</a>';
				echo '</li>';
	
			}
		}
	
		// End unordered list
		echo '</ul>';
}
add_shortcode('listnetwork', 'listnetwork_function');

/*
Add missing TinyMCE buttons
*/
function my_mce_buttons_2($buttons) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'fontsizeselect';


	return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');
?>

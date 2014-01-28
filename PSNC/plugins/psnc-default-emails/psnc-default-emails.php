<?php

/*
Plugin Name: PSNC Default emails
Plugin URI: 
Description: Email notifications for PSNC
Version: 1.0
Author: Jellyhaus
Author URI: http://twitter.com/immw
*/


/** changing default wordpress email settings */

add_filter ("wp_mail_content_type", "my_awesome_mail_content_type");
function my_awesome_mail_content_type() {
	return "text/html";
}
	
add_filter ("wp_mail_from", "my_awesome_mail_from");
function my_awesome_mail_from() {
	return "website@psnc.org.uk";
}
	
add_filter ("wp_mail_from_name", "my_awesome_mail_from_name");
function my_awesome_email_from_name() {
	return "PSNC";
}

// New user registration email

if (!function_exists('wp_new_user_notification')) {

	function wp_new_user_notification($user_id, $plaintext_pass) {
		$user = new WP_User($user_id);
	
		$user_login = stripslashes($user->user_login);
		$user_email = stripslashes($user->user_email);
		
		$email_subject = "Welcome to PSNC ".$user_login."!";
		
		ob_start();
	
		include("email_header.php");
		
		?>
		
		<p>Your account is now set up, and you can login with the following details:</p>
		
		<p>
		Username: <?php echo $user_login ?> <br />
		Password: <?php echo $plaintext_pass ?>
		</p>
		
		<p>To access the members area, or to change/resend your password, please visit <a href="http://psnc.org.uk/lpcs/lpc-members-area/" target="_blank">psnc.org.uk/lpcs/lpc-members-area/</a>.</p>
		
		
		<?php
		include("email_footer.php");
		
		$message = ob_get_contents();
		ob_end_clean();
	
		wp_mail($user_email, $email_subject, $message);
	}
}


// password retrieval

add_filter ("retrieve_password_title", "my_awesome_retrieve_password_title");

function my_awesome_retrieve_password_title() {
	return "Password Reset for PSNC Network";
}

	
add_filter ("retrieve_password_message", "my_awesome_retrieve_password_message");
function my_awesome_retrieve_password_message($content, $key) {
	global $wpdb;
	$user_login = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE user_activation_key = '$key'");
	
	ob_start();
	
	$email_subject = "Password Reset for PSNC Network";
	
	include("email_header.php");
	?>
	
	<p>
		It looks like you want to reset your password for your PSNC Network account.
	</p>

	<p>
		To reset your password, visit the following address, otherwise just ignore this email and nothing will happen.
		<br>
		<?php echo wp_login_url("url") ?>?action=rp&key=<?php echo $key ?>&login=<?php echo $user_login ?>			
	<p>
	
	<?php
	
	include("email_footer.php");
	
	$message = ob_get_contents();

	ob_end_clean();
  
	return $message;
}


?>
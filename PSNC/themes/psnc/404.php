<?php ob_start(); ?>
<?php header("HTTP/1.1 404 Not Found"); ?>
<?php header("Status: 404 Not Found"); ?>


<?php get_header(); ?>

<!--

   _____          _          _   _                            _                                                    
  / ____|        | |        | | | |            _      ____   (_)                                                   
 | |     ___   __| | ___  __| | | |__  _   _  (_)    / __ \   _ _ __ ___  _ __ _____      __                       
 | |    / _ \ / _` |/ _ \/ _` | | '_ \| | | |       / / _` | | | '_ ` _ \| '_ ` _ \ \ /\ / /                       
 | |___| (_) | (_| |  __/ (_| | | |_) | |_| |  _   | | (_| | | | | | | | | | | | | \ V  V /                        
  \_____\___/ \__,_|\___|\__,_| |_.__/ \__, | (_)   \ \__,_| |_|_| |_| |_|_| |_| |_|\_/\_/                         
                                        __/ |        \____/                                                        
  ______ ______ ______ ______ ______ __|___/______ ______ ______ ______ ______ ______ ______                       
 |______|______|______|______|______|______|______|______|______|______|______|______|______|                      
 \ \        / /       | |  (_)              / _|            _       | |    | | |     | |                           
  \ \  /\  / /__  _ __| | ___ _ __   __ _  | |_ ___  _ __  (_)      | | ___| | |_   _| |__   __ _ _   _ ___        
   \ \/  \/ / _ \| '__| |/ / | '_ \ / _` | |  _/ _ \| '__|      _   | |/ _ \ | | | | | '_ \ / _` | | | / __|       
    \  /\  / (_) | |  |   <| | | | | (_| | | || (_) | |     _  | |__| |  __/ | | |_| | | | | (_| | |_| \__ \       
     \/  \/ \___/|_|  |_|\_\_|_| |_|\__, | |_| \___/|_|    (_)  \____/ \___|_|_|\__, |_| |_|\__,_|\__,_|___/       
                                     __/ |                                       __/ |                             
  ______ ______ ______ ______ ______|___/__ ______ ______ ______ ______ ______ _|___/ ______                       
 |______|______|______|______|______|______|______|______|______|______|______|______|______|       _              
  / ____|               | |   (_)                      | | \ \        / / | |     |  __ \          (_)             
 | |  __ _ __ __ _ _ __ | |__  _  ___    __ _ _ __   __| |  \ \  /\  / /__| |__   | |  | | ___  ___ _  __ _ _ __   
 | | |_ | '__/ _` | '_ \| '_ \| |/ __|  / _` | '_ \ / _` |   \ \/  \/ / _ \ '_ \  | |  | |/ _ \/ __| |/ _` | '_ \  
 | |__| | | | (_| | |_) | | | | | (__  | (_| | | | | (_| |    \  /\  /  __/ |_) | | |__| |  __/\__ \ | (_| | | | | 
  \_____|_|  \__,_| .__/|_| |_|_|\___|_ \__,_|_|_|_|\__,_| __  \/  \/ \___|_.__/  |_____/ \___||___/_|\__, |_| |_| 
                  | |      | |       (_)       \ \        / /                (_)    | |      | |   (_) __/ |       
   _____  ___ __  |_|_ _ __| |_ ___   _ _ __    \ \  /\  / /_ _ _ ____      ___  ___| | _____| |__  _ |___/___     
  / _ \ \/ / '_ \ / _ \ '__| __/ __| | | '_ \    \ \/  \/ / _` | '__\ \ /\ / / |/ __| |/ / __| '_ \| | '__/ _ \    
 |  __/>  <| |_) |  __/ |  | |_\__ \ | | | | |    \  /\  / (_| | |   \ V  V /| | (__|   <\__ \ | | | | | |  __/    
  \___/_/\_\ .__/ \___|_|   \__|___/ |_|_| |_|     \/  \/ \__,_|_|    \_/\_/ |_|\___|_|\_\___/_| |_|_|_|  \___|    
           | |                                                                                                     
           |_|                                                                                                     


                                                                                                                                                                                                 
-->

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				
				<?php 
				global $wp_query, $wpdb;
				// check if page requested is published as private
				if ( count($wpdb->get_results($wp_query->request)) > 0 ) : ?>
	   
					<script type="text/javascript">
						/*<![CDATA[*/
						jQuery(window).load(function() {
							jQuery('title').text('LPC Members Area'); 
						});
						/*]]>*/
					</script>
					<h1>LPC Members' Area</h1>
					<p>Please login to access this area.</p>
					<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post" class="inline-login">
						
						<label for="log">Username</label>
						<input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" />
						
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" size="20" />
						
						<input type="submit" name="submit" value="Log in" class="button" />
				       
				       <div style="float:left; clear:left; margin-top:10px;">
					       <label for="rememberme" style="float:none;"> Remember me</label>
					       <input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" style="float:none;" />
				       </div>
				       
				       <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
				       
				       <p><a href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Lost your password?</a> | <a href="<?php echo get_option('home'); ?>/wp-admin/profile.php">Change your password</a></p>
					</form>
				
				
				<?php 
				// else must be a normal 404
				else : ?>
	    
					<h1>Sorry, this page cannot be found</h1>
					<p>The PSNC website has been updated and unfortunately this means page links for the previous version of this site may no longer work.</p>
					<p>You can either use the search box in the top right-hand corner of this site to find what you were looking for or else feel free to browse.</p>
					<p>We hope you find our new website to be better suited to your needs.</p>
					
					<!-- Pull in filename of requested page as a search term -->
					<script type="text/javascript">
						/*<![CDATA[*/
					jQuery(document).ready(function() {
						var url = window.location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
						jQuery('.search-input').val(url); 
					});
						/*]]>*/
					</script>
	
				<?php endif; ?>
			
			
				
			</article>
			<!-- /article -->
	
		</div>
		<!-- /page-content -->

	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
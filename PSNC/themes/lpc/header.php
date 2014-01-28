<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php if(is_home()) : bloginfo('description'); endif; ?> <?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<!-- dns prefetch -->
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		
		<!-- meta -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		
		<meta name="description" content="<?php	
			
				$seo_description = get_post_meta($post->ID, 'seo_description' ,true);
				
				if(is_home()) : bloginfo('description');
				
				elseif (!empty($seo_description)) : echo $seo_description; 
				
				elseif (have_posts() ) : while (have_posts() ) : the_post(); echo strip_tags(get_the_excerpt()); endwhile; 
				
				else : ; 
				
				endif; 
				
			?>">
		
		<!-- icons -->
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
		<link href="/wp-content/themes/psnc/img/icons/touch.png" rel="apple-touch-icon-precomposed">
			
		<!-- css + javascript -->
		<?php wp_head(); ?>

		<script>
		(function(){
			// configure legacy, retina, touch requirements @ conditionizr.com
			conditionizr();
		})();
		</script>
		
		<!--[if ! lte IE 6]><!-->
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/style.css' ?>" media="screen, projection">
		<!--<![endif]-->
		
		<!--[if lte IE 6]>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/ie6.css' ?>" media="screen, projection">
		<![endif]-->
		
		<style>
		/* *, *:after, *:before  {*behavior: url(<?php echo get_template_directory_uri(); ?>/boxsizing.htc);} */
		</style>
		
		<!-- analytics -->		
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(
			  ['_setAccount', '<?php  $options = get_option('ga_account');  echo $options['ga_id'];	?>'],
			  ['_trackPageview'],
			  ['b._setAccount', 'UA-41357847-1'],
			  ['b._trackPageview'],
			  ['c._setAccount', 'UA-4143012-7'],
			  ['c._trackPageview']
			);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
		
		<!--[if lte IE 6]>
		<link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
		<![endif]-->

	</head>
	<body <?php body_class(); ?> id="site-id-<?php global $blog_id; echo $blog_id; //identify the site id ?>">
	
		<!--[if lt IE 7]>
            <div class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</div>
        <![endif]-->
	
		<!--<div class="global-banner">You are currently browsing the new version of the <?php bloginfo('name'); ?> website. <a href="http://www.lpc-online.org.uk" target="_blank">Please click here to return to the old LPC portal.</a></div>-->
	
			<!-- header -->
			<header class="header clear" role="banner">
				
				<!-- wrapper -->
				<div class="wrapper clear">
		
					<!-- logo -->
					<div class="logo three columns">
						<a href="<?php echo home_url(); ?>">
							<?php if ( get_theme_mod( 'lpc_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'lpc_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo-img">
							<?php else : ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/lpc-logo.png" alt="LPC logo" class="logo-img">
							<?php endif; ?>		
						</a>				
					</div>
					<!-- /logo -->
					
					<div class="site-title four columns">
						<h1><?php bloginfo('name'); ?></h1>
					</div>
					<!-- /site-title -->
					
					<div class="pharmacy-logo three columns">
						<img src="<?php echo get_template_directory_uri(); ?>/img/pharmacy-logo.png" alt="Pharmacy - At the heart of our community">
					</div>
					<!-- /pharmacy logo -->
					
					<div class="utility six columns">
						<div class="share-login">
							<a href="http://www.psnc.org.uk"><span>Back to PSNC.org.uk</span></a>&nbsp;&nbsp;|&nbsp;&nbsp;
							<?php if ( !is_user_logged_in() ) : ?>
							<!-- <a href="/login">Login</a> -->
							<?php else : ?>
							You are logged in as <?php  global $current_user; get_currentuserinfo(); echo $current_user->user_login; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>">Logout</a>
							<?php endif ; ?>
							&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo home_url(); ?>/about-us/contact-us">Contact us</a>
						</div>
						<!-- /share-login -->
						
						<div class="quick-links-search">

							<div class="quick-links">
								<a href="#" class="dropdown icon-down-dir">Quick links</a>
								<?php wp_nav_menu( array( 'theme_location' => 'quick-links-menu', 'depth' => -1 , 'items_wrap' => '<ul id="%1$s" class="%2$s clear">%3$s</ul>', 'fallback_cb' => false ) ); ?>
							</div>
							<!-- /quick-links -->
							<?php get_search_form(); ?>
							<div class="clear"></div>
							<h2>Local Pharmaceutical Committee</h2>
						</div>	
						<!-- /quick-links-search -->
					</div>
					<!-- /utility -->
					
				</div>
				<!-- /wrapper -->
					
					<!-- main-nav -->
					<!--[if lt IE 8]>
					<style>
					nav.main-nav ul li a { margin-top: expression(this.offsetHeight < this.parentNode.offsetHeight ? parseInt((this.parentNode.offsetHeight - this.offsetHeight) / 2) + "px" : "0");
					}
					</style>
					<![endif]-->
					
					<div class="noscript-hide">
						<ul class="menu-features">
							
							<?php 
							$args = array('posts_per_page' => 7, 'orderby' => 'meta_value_num', 'order'=>'ASC', 'depth' => 1, 'post_type' => 'menu-feature' );
							$loop = new WP_Query( $args );
							if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
								<!-- article -->
								<li class="featured-menu-item">
									<div class="featured-menu-item-image">
										<?php 
										$customField = get_post_meta($post->ID, 'url', true);
										if (isset($customField[0])) {?>
											<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>"><?php the_post_thumbnail('square'); ?></a>
											<?php
										} else {
							              // No custom field set, don't display link
							              the_post_thumbnail('square'); } ?>
									</div>
									<!-- /image -->
									
									<div class="featured-menu-item-text">
										<h2>
											<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
										</h2>
										<?php html5wp_excerpt('html5wp_index'); ?>
										<p class="menu-order"><?php $menu_o = $wpdb->get_var( "SELECT menu_order FROM $wpdb->posts WHERE ID=" . $post->ID  ); echo $menu_o; ?>
										
										
									</div>
									<!-- /text -->
									
								</li>
								<!-- /li -->
								
								
								
							<?php endwhile; ?>
							
							<?php endif; ?>
							
							<?php wp_reset_query(); ?>
							
						</ul>
					</div>
					<!-- /noscript-hide -->

					
					<nav class="main-nav hideformobile" role="navigation">
						<div class="wrapper clear">
							<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s root-menu">%3$s</ul>', 'container' => false, 'walker' => new My_Walker_Nav_Menu(), 'fallback_cb' => 'theme_nav_fallback', 'depth' => 3 ) ); 
									function theme_nav_fallback() {
										$args = array(
										'depth' => 3,
										'title_li' => ''
										);
										echo ('<ul id="menu-main-menu" class="menu root-menu">');
										wp_list_pages( $args );
										echo ('</ul>');
									}
								?>
						</div>
						<!-- /wrapper -->
					</nav>
					<!-- /main-nav -->
					
					
					<!-- mobile-nav -->
					<?php if (!is_home()) : ?>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery('.main-nav.mobileelement').hide();
								jQuery(".show-hide.main-menu a").click(function(){
									jQuery('.main-nav.mobileelement').slideToggle("fast");
									jQuery(this).toggleClass("open");
									return false;
								});
							});
						</script>
						<div class="show-hide main-menu mobileelement sixteen columns clear"><a href="#">Main menu</a></div>				
					<?php endif; ?>
					
					<nav class="main-nav mobileelement" role="navigation">
						<?php //html5blank_nav(); ?>
						<div class="wrapper clear">
							<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s root-menu">%3$s</ul>', 'container' => false, 'walker' => new My_Walker_Nav_Menu(), 'depth' => 1 ) ); 
								?>
						</div>
						<!-- /wrapper -->
						<hr>
					</nav>
					<!-- /mobile-nav -->
			
			</header>
			<!-- /header -->
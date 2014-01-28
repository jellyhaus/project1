<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<!-- dns prefetch -->
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		
		<!-- meta -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<meta name="description" content="<?php	
			
				$seo_description = get_post_meta($post->ID, 'seo_description' ,true);
				
				if(is_home()) : echo 'PSNC promotes and supports the interests of all NHS community pharmacies in England';
				
				elseif (!empty($seo_description)) : echo $seo_description; 
				
				elseif (have_posts() ) : while (have_posts() ) : the_post(); echo strip_tags(get_the_excerpt()); endwhile; 
				
				else : ; 
				
				endif; 
				
			?>">
		
		<!--[if lte IE 6]>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/ie6.css' ?>" media="screen, projection">
		<![endif]-->
		
		<!--[if lt IE 7]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
		<![endif]-->
		
		<!-- icons -->
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
			
		<!-- css + javascript -->
		<?php wp_head(); ?>

		<script>
		(function(){
			// configure legacy, retina, touch requirements @ conditionizr.com
			conditionizr();
		})();
		</script>
		



		<!-- analytics -->		
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(
			  ['_setAccount', '<?php  $options = get_option('ga_account');  echo $options['ga_id'];	?>'],
			  ['_trackPageview'],
			  ['b._setAccount', 'UA-41357847-1'],
			  ['b._trackPageview']
			);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
	</head>
	<body <?php body_class(); ?> id="site-id-<?php global $blog_id; echo $blog_id; ?>">
		
		<!--[if lte IE 7]>
            <div class="chromeframe" style="background:black;">You are using an outdated browser so elements on this page may not display as intended. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</div>
        <![endif]-->
		
		
	
			<!-- header -->
			<header class="header clear" role="banner" style="z-index:1000;">
				
				<!-- wrapper -->
				<div class="wrapper clear" style="z-index:1000;">
				
					<!-- logo -->
					<div class="logo three columns">
						<a href="<?php echo home_url(); ?>">
							<!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
							<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo" class="logo-img">
						</a>
					</div>
					<!-- /logo -->
					
					<div class="site-title three columns">
						<span>Pharmaceutical<br>Services<br>Negotiating<br>Committee</span>
					</div>
					<!-- /site-title -->
					
					<div class="pharmacy-logo four columns">
						<img src="<?php echo get_template_directory_uri(); ?>/img/pharmacy-logo.png" alt="Pharmacy - At the heart of our community">
					</div>
					<!-- /pharmacy-logo -->
					
					<div class="utility six columns">
						<div class="share-login">
							<?php if ( !is_user_logged_in() ) : ?>
							<!-- <a href="<?php echo home_url(); ?>/login">Login</a> -->
							<?php else : ?>
							You are logged in as <?php  global $current_user; get_currentuserinfo(); echo $current_user->user_login; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>">Logout</a>
							<?php endif ; ?>
						</div>
						<!-- /share-login -->
						
						<div class="quick-links-search">

							<div class="quick-links">
								<a href="#" class="dropdown icon-down-dir">Quick links</a>
								<?php wp_nav_menu( array( 'theme_location' => 'quick-links-menu', 'depth' => -1 , 'items_wrap' => '<ul id="%1$s" class="%2$s clear">%3$s</ul>', 'fallback_cb' => false ) ); ?>
							</div>
							<!-- /quick-links -->
							<?php get_search_form(); ?>
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
											<? if (isset($customField[0])) {?>
											<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
											<?php
										} else { ?>
											<a href="#" title="<?php the_title(); ?>" onclick="return false;"><?php the_title(); ?></a> 
										 <?php	} ?>
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
						<?php //html5blank_nav(); ?>
						<div class="wrapper clear">
							<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s root-menu">%3$s</ul>', 'container' => false, 'walker' => new My_Walker_Nav_Menu(), 'depth' => 3 ) ); 
								
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
						
					</nav>
					<!-- /mobile-nav -->
			
			</header>
			<!-- /header -->			
			
			
			
			
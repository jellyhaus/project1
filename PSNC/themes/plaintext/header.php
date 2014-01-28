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

		<meta name="description" content="<?php	if(is_home()) : bloginfo('description'); else : $seo_description = get_post_meta($post->ID, 'seo_description' ,true); echo $seo_description; endif; ?>">
		
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
	<body <?php body_class(); ?>>
		
		<!--[if lte IE 7]>
            <div class="chromeframe" style="background:black;">You are using an outdated browser so elements on this page may not display as intended. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</div>
        <![endif]-->
	
		<div class="global-banner">You are currently browsing the new version of the PSNC website. <a href="http://archive.psnc.org.uk">Please click here to return to the old version.</a></div>
		
		
	
			<!-- header -->
			<header class="header clear" role="banner" style="z-index:1000;">
				
				<!-- wrapper -->
				<div class="wrapper clear" style="z-index:1000;">
					
					<div class="site-title ten columns">
						<?php echo get_bloginfo('name'); ?>
					</div>
					
					<div class="utility six columns">
						<?php get_search_form(); ?>
					</div>
					<!-- /utility -->
					
				</div>
				<!-- /wrapper -->
				
				<div style="clear:both; width:100%;"></div>
					
					<nav class="main-nav hideformobile" role="navigation">
						<?php //html5blank_nav(); ?>
						<div class="wrapper clear">
							<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s root-menu">%3$s</ul>', 'container' => false, 'depth' => 1 ) ); 
								
								?>
						</div>
						<!-- /wrapper -->
					</nav>
					<!-- /main-nav -->
			
			</header>
			<!-- /header -->			
			
			
			
			
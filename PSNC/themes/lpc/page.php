<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<?php $parent_page = get_top_parent_page_id($post->ID); $parent_page_title = get_the_title($parent_page); $parent_page_uri = get_page_uri($parent_page); ?>
			<nav>
				<ul>
					<li class="hideformobile"><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
					<!-- mobile navigation -->
					<li class="mobileelement toggle">
						<script type="text/javascript">
							jQuery(document).ready(function(){
								if (jQuery(window).width() < 500) {
									jQuery(".sidebar-nav ul li.page_item").hide();
									jQuery(".sidebar-nav ul li a.parent-page").hide();
									jQuery(".show-hide.sidebar a").click(function(){
										jQuery('.sidebar-nav ul li.page_item').slideToggle("fast");
										jQuery(this).toggleClass("open");
										return false;
									});
								}
							});
						</script>
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all pages in <span style="font-family:UbuntuBold;"><?php echo $parent_page_title; ?></span> section</a></div>
					</li>
					<?php $args = array('child_of' => $parent_page, 'title_li' => '<a href="' . $parent_page_uri . '" class="parent-page">' . $parent_page_title . '</a>', 'post_status' => 'publish,private'  ); ?>
					<?php wp_list_pages($args); ?>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('news-thumb'); ?>
			<?php endif; ?>
			<!-- /post thumbnail -->

			<h1><?php the_title(); ?></h1>
			
			<hr style="height:0;">
	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
				<?php // Check if post has expired
					
					$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
					if (!empty($emptycheck)) :
						$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
						$now = date('U'); // get today's date as unicode
						
					endif;
				
					if ($expiry < $now) :	// check if value is not empty AND expiry hasn't passed
						echo 'Sorry, this content has expired.';
					else : ?>
			
						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
							<?php 
							the_content('Continue Reading');
							?>
		
							<br class="clear">
							
							<?php edit_post_link(); ?>
							
							
							
						</article>
						<!-- /article -->
							
					<?php /* end expiration check*/ endif; ?>
							
						
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					
					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
					
				</article>
				<!-- /article -->
			
			<?php endif; ?>
	
		</div>
		<!-- /page-content -->

	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sixteen columns breadcrumb"><?php if(function_exists('the_breadcrumbs')) the_breadcrumbs(); ?></div>
	
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
									jQuery(".sidebar-nav ul li.categories").hide();
									jQuery(".show-hide.sidebar a").click(function(){
										jQuery('.sidebar-nav ul li.categories').slideToggle("fast");
										jQuery(this).toggleClass("open");
										return false;
									});
								}
							});
						</script>
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all Events Categories</a></div>
					</li>
					<li class="categories"><a href="#" onclick="return false;" style="cursor: text; background:grey; color:white;">Events Categories:</a>
						<ul>
						<?php
						$args_list = array(
							'taxonomy' => 'our-events-category',
							'hierarchical' => true,
							'echo' => '0',
							'title_li' => ''
						);	 
						echo wp_list_categories($args_list);
						?>
						</ul>
					</li>
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
			<p><?php $event_date = get_post_meta($post->ID, 'event_date' ,true); echo gmdate("l, j F, Y", $event_date); ?> <?php $event_time = get_post_meta($post->ID, 'event_time' ,true); echo $event_time; ?><br><?php $event_location = get_post_meta($post->ID, 'event_location' ,true); echo $event_location; ?></p>
			
			<hr style="height:0;">
	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<?php the_content(); ?>
					
					<br class="clear">
					
					<?php edit_post_link(); ?>
					
				</article>
				<!-- /article -->
				
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
		
		<hr>
	
		<div class="page-news-releases sixteen columns">
			
				<h2><a href="<?php echo get_bloginfo("url"); ?>/our-events" class="view-more">View all events ></a></h2>

					<div class="slider4col">
					<?php
					$args = array( 'post_type' => 'our-events', 'posts_per_page' => 12 );
					$loop = new WP_Query( $args );

						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
							<!-- article -->		
							<article id="post-<?php the_ID(); ?>"  class="news-box">
								<!-- post title -->
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- /post title -->
								<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
								<?php edit_post_link(); ?>
							</article>
							<!-- /article -->
							
						<?php endwhile; ?>
						<?php else: ?>
							<!-- article -->
							<article>
								<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
							</article>
							<!-- /article -->
						<?php endif; ?>
					</div>
					<!-- /slider4col -->
		
		</div>
		<!-- /home-news-releases -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
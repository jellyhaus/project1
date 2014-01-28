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
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all Latest News Categories</a></div>
					</li>
					<li class="categories"><a href="#" onclick="return false;" style="cursor: text">News categories:</a>
						<ul>
						<?php
						$args_list = array(
							'taxonomy' => 'our-latest-news-category',
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
		
			<h1 class="mobileelement" style="margin:0.5em 0 0 0; clear: left; float: left; width: 100%;"><?php the_title(); ?></h1>
		
			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('news-thumb'); ?>
			<?php endif; ?>
			<!-- /post thumbnail -->

			<h1 class="hideformobile"><?php the_title(); ?></h1>
			<p><?php the_time('F j, Y'); ?></p>
			
	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<?php the_content(); ?>
					
					<?php /* the_shortlink(__('Shortlink')); */ ?> 
					
					<br class="clear">
					
					<?php edit_post_link(); ?>
					
				</article>
				<!-- /article -->
				
				<hr style="height:0;">
			
				<p><?php echo get_the_term_list( $post->ID, 'our-latest-news-category', 'Posted in: ', ', ', '' );  ?></p>
				
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
			
				<h2><a href="<?php echo get_bloginfo("url"); ?>/latest-news" class="view-more">More Latest News ></a></h2>
				<div style="clear:both; height:10px; width:100%;"></div>

					<div class="slider4col">
					<?php
					$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => 12 );
					$loop = new WP_Query( $args );

						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>							
							<!-- article -->
							<article id="post-<?php the_ID(); ?>"  class="news-box">
								<!-- post thumbnail -->
								<div class="news-thumb">
								<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_post_thumbnail('news-thumb'); // Declare pixel size you need inside the array ?>
									</a>
									<?php else : ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="border:1px solid #ccc; display:block; width:100%; height:105px;">
									</a>
								<?php endif; ?>
								</div>
								<!-- /post thumbnail -->
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
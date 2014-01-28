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
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all Resources Categories</a></div>
					</li>
					<li class="categories"><a href="#" onclick="return false;" style="cursor: text">Categories:</a>
						<ul>
						<?php
						$args_list = array(
							'taxonomy' => 'our-publications-category',
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
		
		
		<div class="page-content twelve columns clear">

			<h1><?php $term = $wp_query->queried_object; echo $term->name; ?> Resources</h1>
	
			<?php 
			$i = 1;
			if (have_posts()): while (have_posts()) : the_post(); ?>
			
			<?php // Check if post has expired
				
			$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
			if (!empty($emptycheck)) :
				$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
				$now = date('U'); // get today's date as unicode
				
				if ($expiry < $now) :	// check if value is not empty AND expiry hasn't passed
					
				else : ?>
	
				<!-- article -->
				<article id="post-<?php the_ID(); ?>"  class="news-template-box">
				
					<!-- post thumbnail -->
					<div class="news-thumb clear">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('news-thumb'); // Declare pixel size you need inside the array ?>
						</a>
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
				
				<?php if($i % 3 == 0) {echo '<div class="clear hideformobile" style="width:100%;"></div>';} $i++; ?>
				
				<?php endif; ?>
				
			<?php else : ?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>"  class="news-template-box">
				
					<div class="news-thumb">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('news-thumb'); // Declare pixel size you need inside the array ?>
						</a>
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
				
				<?php if($i % 3 == 0) {echo '<div class="clear hideformobile" style="width:100%;"></div>';} $i++; ?>
				
			<?php endif; //end check for expiry ?>
			
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
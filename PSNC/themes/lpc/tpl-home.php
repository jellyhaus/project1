<?php  get_header(); ?>

<?php
// check for LPC portal site
global $blog_id;
if ($blog_id == 92) : ?>
   <div class="wrapper clear">
   	<section role="main">
   		<div class="sixteen columns">	
	   		<?php
			$my_id = 94;
			$post_id_94 = get_post($my_id);
			$content = $post_id_94->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			echo $content;
			?>
   		</div>
   	</section>
   </div>
<?php else : ?>

<div class="wrapper clear">
	
	<!-- section -->
	<section role="main">
	
		<h1 class="home-title"><?php echo get_bloginfo ( 'description' ); ?></h1>
		
		<div class="home-intro five columns clear">
			<?php
			    $options = get_option('site_description');
			    echo $options['sometextarea'];
			?>
		</div>
		<!-- /home-intro -->
		
		<div class="eleven columns">
			<nav class="slideshow-nav"></nav>
		</div>
		
		<div class="eleven columns clear">
		
			<div class="home-page slideshow">
			
				<?php 
				$args = array( 'post_type' => 'feature', 'posts_per_page' => 5, 'orderby' => 'menu_order', 'order'=>'ASC' );
				$loop = new WP_Query( $args );
				if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
		
					<!-- article -->
					<article id="post-<?php the_ID(); ?>"  class="slideshow-item">
						
						<div class="slideshow-mask"></div>
						<div class="slideshow-image">
							<?php 
							$customField = get_post_meta($post->ID, 'url', true);
							if (isset($customField[0])) {?>
								<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>"><?php the_post_thumbnail('slideshow-size'); // Declare pixel size you need inside the array ?></a>
								<?php
							} else {
				              // No custom field set, don't display link
				              the_post_thumbnail('slideshow-size'); } ?>
						</div>
						<!-- /slideshow-image -->
						
						<div class="slideshow-text">
							<h2>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h2>
							<?php html5wp_excerpt('html5wp_index'); ?>
						</div>
						<!-- /slideshow-text -->
						
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
			<!-- /slideshow -->
			
		</div>
		<!-- /eleven columns clear -->
		
		<div class="home-news-releases-title sixteen columns">
		
			<h2>Latest news releases <a href="<?php echo get_bloginfo("url"); ?>/latest-news" class="view-more">View more news ></a></h2>
				
			<hr class="dashed" style="height:0;">
		
		</div>
		<!-- /home-news-releases-title -->
		
		<div class="slider home-news-releases sixteen columns">
			
			<div class="slider4col">
			<?php 
			$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => 12,'orderby' => 'date' );
			$loop = new WP_Query( $args );
			if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
			
			<?php // Check if post has expired
				
			$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
			if (!empty($emptycheck)) :
				$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
				$now = date('U'); // get today's date as unicode
				
				if ($expiry < $now) :	// check if value is not empty AND expiry hasn't passed
					
				else : ?>
	
				<!-- article -->
				<article id="post-<?php the_ID(); ?>"  class="news-box slide-box">
				
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
				
				<?php endif; ?>
				
			<?php else: ?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>"  class="news-box slide-box">
				
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
				
			<?php endif; // end check for expiry ?>
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, nothing here.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			</div>
			<!-- /slider4col -->
		
		</div>
		<!-- /slider -->
		
		<div class="home-resources one-third column latest-psnc">
		
			<h2>Latest PSNC News</h2>
			
			<?php
                        global $switched;
                        switch_to_blog(1); //switched to 2 ?>

                        <?php 
						$args = array( 'post_type' => 'our-latest-news ', 'posts_per_page' => 4 );
						$loop = new WP_Query( $args );
						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
				
							<!-- article -->
							<article id="post-<?php the_ID(); ?>">
								
								<!-- post title -->
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- /post title -->
								
								<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
								
								<span class="date"><?php the_time('F j, Y'); ?></span>
								
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

                    <?php restore_current_blog(); //switched back to main site ?>
		
		</div>
		<!-- /home-resources -->
		
		<div class="home-events one-third column">
		
			<h2>Events</h2>
			
			<?php 
			$args = array( 'post_type' => 'our-events ', 'posts_per_page' => 3, 'meta_key' => 'event_date', 'orderby' => 'meta_value_num', 'order' => 'ASC' );
			$loop = new WP_Query( $args );
			if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
			
			<?php // Check if post has expired
				
			$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
			if (!empty($emptycheck)) :

				$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
				$now = date('U'); // get today's date as unicode
				
				if ($expiry < $now) :	// check if value is not empty AND expiry hasn't passed
					
				else : ?>
	
				<!-- article -->
				<article id="post-<?php the_ID(); ?>">
					
					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<span class="date"><?php $event_date = get_post_meta($post->ID, 'event_date' ,true); echo date("l, j F, Y", $event_date); ?> <?php $event_time = get_post_meta($post->ID, 'event_time' ,true); echo $event_time; ?><br><?php $event_location = get_post_meta($post->ID, 'event_location' ,true); echo $event_location; ?></span>
					
					<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
					
					<?php edit_post_link(); ?>
					
				</article>
				<!-- /article -->
				
				<?php endif; ?>
				
			<?php else : ?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>">
					
					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<span class="date"><?php $event_date = get_post_meta($post->ID, 'event_date' ,true); echo gmdate("l, j F, Y", $event_date); ?> <?php $event_time = get_post_meta($post->ID, 'event_time' ,true); echo $event_time; ?><br><?php $event_location = get_post_meta($post->ID, 'event_location' ,true); echo $event_location; ?></span>
					
					<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
					
					<?php edit_post_link(); ?>
					
				</article>
				<!-- /article -->
				
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
		<!-- /home-events -->
		
		<div class="home-utility one-third column">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Utility') ) : ?>
			<?php endif; ?>
		
		</div>
		<!-- /home-utility -->

	
	</section>
	<!-- /section -->

</div>
<!-- /wrapper -->

<?php /* end checking for LPC portal */ endif; ?>

<?php get_footer(); ?>
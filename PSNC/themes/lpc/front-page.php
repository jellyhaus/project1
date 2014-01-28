<?php get_header(); ?>

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
			    echo wpautop($options['sometextarea']);
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
							<?php the_content(); ?>
						</div>
						<!-- /slideshow-text -->
						
					</article>
					<!-- /article -->
					
				<?php endwhile; ?>
				
				<?php else: ?>
				
					<!-- article -->
					<article>
						<h2><?php _e( 'Sorry, nothing to display here.', 'html5blank' ); ?></h2>
					</article>
					<!-- /article -->
				
				<?php endif; ?>
				
				<?php wp_reset_query(); ?>
			</div>
			<!-- /slideshow -->
			
		</div>
		<!-- /eleven columns clear -->
		
		<div class="home-news-releases-title sixteen columns">
		
			<h2><a href="<?php echo get_bloginfo("url"); ?>/latest-news">Latest news</a></h2>
			<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/latest-news" >View more news ></a></p>
				
			<hr class="dashed" style="height:0;">
		
		</div>
		<!-- /home-news-releases-title -->
		
		<div class="slider home-news-releases sixteen columns">
			
			<div class="slider4col">
			<?php 
			$counter=0; // used to break the loop once 3 posts have been printed
			$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1,'orderby' => 'date' );
			$loop = new WP_Query( $args );
			if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
			
			<?php // Check if post has expired
				
			$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
			$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
			$now = date('U'); // get today's date as unicode
			
			if ($expiry > $now || empty($emptycheck)) :	// check if expiry date is in the future OR expiry date is empty ?>
	
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
				
				<?php $counter++; // increment the counter ?>
				
				
					<?php else : // must mean content has expired ?>	
					<?php endif; //end check for expiry ?>
				
				<?php if($counter == 12) : break; endif; // break the loop if 3 posts have been reached ?>
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, nothing here.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
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
                        $counter=0; // used to break the loop once 3 posts have been printed
						$args = array( 'post_type' => 'our-latest-news ', 'posts_per_page' => -1 );
						$loop = new WP_Query( $args );
						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
						
						<?php // Check if post has expired
				
						$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
						$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
						$now = date('U'); // get today's date as unicode
						
						if ($expiry > $now || empty($emptycheck)) :	// check if expiry date is in the future OR expiry date is empty ?>
							<!-- article -->
							<article id="post-<?php the_ID(); ?>">
								
								<!-- post title -->
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- /post title -->
								
								<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
								
								<span class="date"><?php the_time('F j, Y'); ?></span>
								
								<p class="clear"><?php edit_post_link(); ?></p>
								
							</article>
							<!-- /article -->
							<?php $counter++; // increment the counter ?>
				
				
							<?php else : // must mean content has expired ?>	
							<?php endif; //end check for expiry ?>
						
						<?php if($counter == 4) : break; endif; // break the loop if 3 posts have been reached ?>
							
						<?php endwhile; ?>
						
						<?php else: ?>
						
							<!-- article -->
							<article>
								<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
							</article>
							<!-- /article -->
						
						<?php endif; ?>

                    <?php restore_current_blog(); //switched back to main site ?>
                    
                    <?php wp_reset_query(); ?>
		
		</div>
		<!-- /home-resources -->
		
		<div class="home-events one-third column">
		
			<h2><a href="<?php echo home_url(); ?>/our-events/" style="color:#93378a;">Events</a></h2>
			
			<?php 
			$today = date('U');
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			query_posts(array(
				'paged' => $paged, 
				'posts_per_page' => 3, 
				'post_type' => 'our-events', 
				'meta_key' => 'event_date', 
				'orderby' => 'meta_value_num', 
				'order' => 'ASC', 
				'meta_query' => array (	// check to see if post custom meta (event_date) is not earlier than today's date
					array (	
						'key' => 'event_date',	
						'value' => $today, 
						'compare' => '>=', 
						'type' => 'NUMERIC'	
				))
			));
			if (have_posts()): while (have_posts()) : the_post(); ?>
	
				<!-- article -->
				<article id="post-<?php the_ID(); ?>">
					
					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<p class="date">
						<?php 
							
							$event_date = get_post_meta($post->ID, 'event_date' ,true); 
							echo gmdate("l, j F, Y", $event_date);

							$event_time = get_post_meta($post->ID, 'event_time' ,true); 
							
							if (isset($event_time)) { // check if a time has been entered
							    echo ',&nbsp;'.$event_time;
							}
							
							echo '<br>';
							
							$event_location = get_post_meta($post->ID, 'event_location' ,true); 
							echo $event_location; 
						?>
					</p>
					
					<?php html5wp_excerpt('html5wp_index'); ?>
					
					<p class="clear"><?php edit_post_link(); ?></p>
					
				</article>
				<!-- /article -->
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					<h2>Sorry, no events available.</h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
			<p><a href="<?php echo home_url(); ?>/our-events/">View more events >></a></p>
		
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
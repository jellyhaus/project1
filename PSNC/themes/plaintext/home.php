<?php get_header(); ?>

<div class="wrapper clear">
	
	<!-- section -->
	<section role="main">
		
		<div class="psnc-home-intro sixteen columns clear">
			<?php
			    $options = get_option('site_description');
			    echo $options['sometextarea'];
			?>
			<!-- banner-ad -->
			<?php 
				$current_page = get_the_title();
				$args = array( 'post_type' => 'psnc-ads', 'posts_per_page' => -1 );
				$loop = new WP_Query( $args );
				if (have_posts()): while ($loop->have_posts()) : $loop->the_post();
					
					$list_of_pages = get_post_meta($post->ID, 'list_of_pages' ,true); 
					if ($list_of_pages == 'Home page') :
						echo '<div class="banner-ad home">'	;			
						the_content();
						echo '<script>jQuery(".psnc-home-intro ul li").hide().slice(0, 3).show();</script>';
						echo '</div>';	
						break;				
					elseif ($list_of_pages == 'All pages'):	
						echo '<div class="banner-ad home">'	;
						the_content();
						echo '<script>jQuery(".psnc-home-intro ul li").hide().slice(0, 3).show();</script>';
						echo '</div>';
						break;
					else :
					endif;	
			endwhile;
			endif;
			wp_reset_query();
			?>
			<!-- /banner-ad -->
		</div>
		<!-- /home-intro -->

		
		<div class="home-news-releases-title sixteen columns">
			
			<h2><a href="<?php echo get_bloginfo("url"); ?>/latest-news">Latest news</a></h2>
			
				
			<hr class="dashed" style="height:0;">
		
		</div>
		<!-- /home-news-releases-title -->
		
		<div class="home-news-releases sixteen columns">

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

					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<?php the_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
					
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
		<!-- /home-news-releases -->
		
		<div class="home-resources eight columns">
		
			<h2>Resources</h2>
			
			<?php 
			$counter=0; // used to break the loop once 3 posts have been printed
			$args = array( 'post_type' => 'our-publications ', 'posts_per_page' => 3 );
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
					
				</article>
				<!-- /article -->
				
				<?php $counter++; // increment the counter ?>
				
				
				<?php else : // must mean content has expired ?>	
				<?php endif; //end check for expiry ?>
			
			<?php if($counter == 3) : break; endif; // break the loop if 3 posts have been reached ?>
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			<p><a href="/psncs-work/resources/">View all resources >></a></p>
		
		</div>
		<!-- /home-resources -->
		
		<div class="home-events eight columns">
		
			<h2><a href="<?php echo home_url(); ?>/psncs-work/our-events/" style="color:#93378a;">Events</a></h2>
			
			<?php 
			$counter=0; // used to break the loop once 3 posts have been printed
			$args = array( 'post_type' => 'our-events', 'posts_per_page' => -1, 'meta_key' => 'event_date', 'orderby' => 'meta_value_num', 'order' => 'ASC' );
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
					
					<p class="date"><?php $event_date = get_post_meta($post->ID, 'event_date' ,true); echo date("l, j F, Y", $event_date); ?> <?php $event_time = get_post_meta($post->ID, 'event_time' ,true); echo $event_time; ?><br><?php $event_location = get_post_meta($post->ID, 'event_location' ,true); echo $event_location; ?></p>
					
					<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
					
					<p class="clear"><?php edit_post_link(); ?></p>
					
				</article>
				<!-- /article -->
				<?php $counter++; // increment the counter ?>
				
				
				<?php else : // must mean content has expired ?>	
				<?php endif; //end check for expiry ?>
			
			<?php if($counter == 3) : break; endif; // break the loop if 3 posts have been reached ?>
				
			<?php endwhile; ?>
			
			<?php else: ?>
			
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
			<p><a href="/psncs-work/our-events/">View more events >></a></p>
		
		</div>
		<!-- /home-events -->

	
	</section>
	<!-- /section -->

</div>
<!-- /wrapper -->

<?php get_footer(); ?>
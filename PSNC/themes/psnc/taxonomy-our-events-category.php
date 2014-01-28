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
					<li><a href="#" onclick="return false;" style="cursor: text; background:grey; color:white;">Pages in this section:</a>
					<?php $args = array('child_of' => $parent_page, 'title_li' => '<a href="' . $parent_page_uri . '" class="parent-page">' . $parent_page_title . '</a>', 'post_status' => 'publish,private' ); ?>
					<?php wp_list_pages($args); ?>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns clear">

			
			
			
	
			<?php 
			$i = 1;
			$today = date('U');
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$term = $wp_query->queried_object;
			$this_cat_slug = $term->slug; 
			$this_cat_title = $term->name; 
			query_posts(array(
				'our-events-category' => $this_cat_slug, 'paged' => $paged, 'posts_per_page' => 6, 'post_type' => 'our-events', 'meta_key' => 'event_date', 'orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_query' => array (	array (	'key' => 'event_date',	'value' => $today, 'compare' => '>=', 'type' => 'NUMERIC'	))
			)); ?>
			
			<h1>Upcoming events in <?php echo $this_cat_title; ?></h1>
			
			<?php
			if (have_posts()): while (have_posts()) : the_post(); ?>
			
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>"  class="news-template-box">
					
					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<?php 
					$event_date = get_post_meta($post->ID, 'event_date' ,true);
					
					if (is_numeric($event_date)) { ?>
					
					<p class="date">
						<?php 
							
							echo date("l, j F, Y", $event_date);
							
							$event_time = get_post_meta($post->ID, 'event_time' ,true); 
							
							if (isset($event_time)) { // check if a time has been entered
							    echo ',&nbsp;'.$event_time;
							}
							
							echo '<br>';
							
							$event_location = get_post_meta($post->ID, 'event_location' ,true); 
							echo $event_location; 
						?>
					</p>
					
					<?php } ?>
					
					<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
					
					<?php edit_post_link(); ?>
					
				</article>
				<!-- /article -->
				
				<?php if($i % 3 == 0) {echo '<div class="clear hideformobile" style="width:100%;"></div>';} $i++; ?>
				
			
			<?php endwhile; ?>
			
			<?php else: ?>
	
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, no upcoming events in this category.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>
			
			<div style="width:100%; clear:both;"></div>
			
			<nav class="newer-older">
			    <?php previous_posts_link('&laquo; More recent events') ?>
			    <?php next_posts_link('More events &raquo;') ?>
			</nav>
			
			<?php wp_reset_query(); ?>
			
			<hr>
			
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('.past-events').hide();
					$('.past-events-title').click(function () {
						var link = $('span', this);
						$('.past-events').slideToggle(0, function () {
							if ($(this).is(":visible")) {
								link.text('Hide past events');
							} else {
								link.text('View past events');
							}
						});
						return false;
					});
				});
			</script>
			
			<?php 
			$today = date('U');
			query_posts(array(
				'our-events-category' => $this_cat_slug, 'posts_per_page' => -1, 'post_type' => 'our-events', 'meta_key' => 'event_date', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_query' => array (	array (	'key' => 'event_date',	'value' => $today, 'compare' => '<=', 'type' => 'NUMERIC'	))
			)); ?>
			
			<h1 class="past-events-title"><span>View past events in</span> <?php echo $this_cat_title; ?> (<?php global $wp_query; echo $wp_query->found_posts; ?>)</h1>
			
			<hr>
			
			<div class="past-events">
			
			<?php
			if (have_posts()): while (have_posts()) : the_post(); ?>
			
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>">
					
					<!-- post title -->
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<!-- /post title -->
					
					<?php 
					$event_date = get_post_meta($post->ID, 'event_date' ,true);
					
					if (is_numeric($event_date)) { ?>
					
					<p class="date">
						<?php 
							
							echo date("l, j F, Y", $event_date);
							
							$event_time = get_post_meta($post->ID, 'event_time' ,true); 
							
							if (isset($event_time)) { // check if a time has been entered
							    echo ',&nbsp;'.$event_time;
							}
							
							echo '<br>';
							
							$event_location = get_post_meta($post->ID, 'event_location' ,true); 
							echo $event_location; 
						?>
					</p>
					
					<?php } ?>
					
				</article>
				<!-- /article -->				
			
			<?php endwhile; ?>
			
			<?php else: ?>
	
				<!-- article -->
				<article>
					<h2><?php _e( 'Sorry, no past events.', 'html5blank' ); ?></h2>
				</article>
				<!-- /article -->
			
			<?php endif; ?>

			</div>
			<!-- /past-events -->
			
			<?php wp_reset_query(); ?>
	
		</div>
		<!-- /page-content -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
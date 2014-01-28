<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<?php $parent_page = get_top_parent_page_id($post->ID); $parent_page_title = get_the_title($parent_page); $parent_page_uri = get_page_uri($parent_page); ?>
			<nav>
				<ul>
					<li class="hideformobile"><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
					<?php $args = array('child_of' => $parent_page, 'title_li' => '<a href="' . $parent_page_uri . '" class="parent-page">' . $parent_page_title . '</a>', 'post_status' => 'publish,private' ); ?>
					<?php wp_list_pages($args); ?>
					
					
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">
		
			<div class="breadcrumb"><?php if(function_exists('the_breadcrumbs')) the_breadcrumbs(); ?></div>
			
			<!-- banner-ad -->
			<div class="banner-ad page">
			<?php 
				$current_page = get_the_title();
				$bannerargs = array( 'post_type' => 'psnc-ads', 'posts_per_page' => -1 );
				$loop = new WP_Query( $bannerargs );
				if (have_posts()): while ($loop->have_posts()) : $loop->the_post();
					
					$list_of_pages = get_post_meta($post->ID, 'list_of_pages' ,true); 
					if ($list_of_pages == $current_page) :				
						the_content();	
						break;				
					elseif ($list_of_pages == 'All pages'):	
						the_content();
						break;
					else :
					endif;	
			endwhile;
			endif;
			wp_reset_query();
			?>
			</div>
			<!-- /banner-ad -->

	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
			<?php // Check if post has expired
				
				$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
				$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
				$now = date('U'); // get today's date as unicode
				
				if ($expiry > $now || empty($emptycheck)) :	// check if expiry date is in the future OR expiry date is empty ?>
			
			
						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
							<?php the_title(); ?>
							
							<?php 
							the_content('Continue Reading');
							?>
							
							
		
							<br class="clear">
							
							<?php edit_post_link(); ?>
							
							
							
						</article>
						<!-- /article -->	
						
				<?php else : // must mean content has expired ?>	
					<p>Sorry, this content has expired.</p>
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
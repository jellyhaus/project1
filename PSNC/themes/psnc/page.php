<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<?php $parent_page = get_top_parent_page_id($post->ID); $parent_page_title = get_the_title($parent_page); $parent_page_uri = get_page_uri($parent_page); ?>
			<nav>
				<ul>
					<li class="hideformobile"><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
					
					<!-- mobile navigation toggle -->
					<li class="mobileelement toggle">
						<script type="text/javascript">
							jQuery(document).ready(function($){
								if ($(window).width() < 500) {
									$(".sidebar-nav ul li.page_item").hide();
									$(".sidebar-nav ul li a.parent-page").hide();
									$(".show-hide.sidebar a").click(function(){
										$('.sidebar-nav ul li.page_item').slideToggle("fast");
										$(this).toggleClass("open");
										return false;
									});
								}
							});
						</script>
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all pages in <?php echo $parent_page_title; ?> section</a></div>
					</li>
					<?php
						$args = array(
							'child_of' => $parent_page, 
							'title_li' => '<a href="' . $parent_page_uri . '" class="parent-page">' . $parent_page_title . '</a>', 
							'post_status' => 'publish,private' 
						); 
					?>
					<?php wp_list_pages($args); ?>
					
					
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">
		
			<div class="breadcrumb"><?php if(function_exists('the_breadcrumbs')) the_breadcrumbs(); // calls on the breadcrumb function ?></div>
		
			<h1 class="mobileelement" style="margin:0.5em 0 0 0; clear: left; float: left; width: 100%;"><?php the_title(); ?></h1>

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('news-thumb'); ?>
			<?php endif; ?>
			<!-- /post thumbnail -->
			
			
			<div class="banner-ad page">
			<?php 
			// Banner ad - uses 'psnc-ads' Custom Post Type
				$current_page = get_the_title(); // grabs current page title to use for banner ad conditional
				$bannerargs = array( 
					'post_type' => 'psnc-ads', 
					'posts_per_page' => -1 
				);
				$loop = new WP_Query( $bannerargs );
				if (have_posts()): while ($loop->have_posts()) : $loop->the_post();
					
					$list_of_pages = get_post_meta($post->ID, 'list_of_pages' ,true); 
					if ($list_of_pages == $current_page || $list_of_pages == 'All pages') :	// if 'list_of_pages' option is the same as the current page OR 'list_of_pages' option is set to 'All pages'		
						the_content();	
						break;
					endif;	
			endwhile;
			endif;
			wp_reset_query();
			?>
			</div>
			<!-- /banner-ad -->

			<h1 class="hideformobile"><?php the_title(); ?></h1>

	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
			<?php // Check if post has expired
				
				$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // grab value to see if it is set
				$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
				$now = date('U'); // get today's date as unicode
				
				if ($expiry > $now || empty($emptycheck)) :	// check if expiry date is in the future OR expiry date is empty ?>
			
			
						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
							<?php the_content(); ?>
							
							<br class="clear">
							
							<?php edit_post_link(); ?>
						
						</article>
						<!-- /article -->	
						
				<?php else : // must mean content has expired ?>	
					<p>Sorry, this content has expired.</p>
				<?php endif; //end check for expiry ?>						
						
				
			<?php endwhile; endif; ?>
	
		</div>
		<!-- /page-content -->
		
		<hr>
	
		<div class="page-news-releases sixteen columns">
			
			<!-- Conditional news items. Structure:
				1. Checks if is a main site section OR an ancestor of the section parent
				2. Sets the correct arguments to query the correct taxonomy
				3. Opens a div to enable specific colouring
				4. <h2> Title
				5. Content
			 -->
			<?php
			$ancestors = get_post_ancestors($post); // grabs the post ancestors to make sure news items appear all the way down the site tree
			if(is_page("PSNC's Work") || in_array(41,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'psnc-news' ); ?>
				<div class="psnc-news">
				<h2>Latest PSNC news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/psnc-news/" >View more PSNC news ></a></p>
			<?php
			elseif(is_page("Contract and IT") || in_array(33,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'contract-and-it' ); ?>
				<div class="cit-news">
				<h2>Latest Contract &amp; IT news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/contract-and-it/" >View more Contract &amp; IT news ></a></p>
			<?php
			elseif(is_page("Dispensing and Supply") || in_array(34,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'dispensing-and-supply' ); ?>
				<div class="ds-news">
				<h2>Latest Dispensing and Supply news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/dispensing-and-supply/" >View more Dispensing and Supply news ></a></p>
			<?php
			elseif(is_page("Services and Commissioning") || in_array(35,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'services-commissioning' ); ?>
				<div class="sc-news">
				<h2>Latest Services and Commissioning news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/services-commissioning/" >View more Services and Commissioning news ></a></p>
			<?php
			elseif(is_page("The Healthcare Landscape") || in_array(36,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'the-healthcare-landscape' ); ?>
				<div class="hl-news">
				<h2>Latest Healthcare Landscape news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/the-healthcare-landscape/" >View more Healthcare Landscape news ></a></p>
			<?php
			elseif(is_page("LPCs") || in_array(37,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'latest-lpc-news' ); ?>
				<div class="lpc-news">
				<h2>Latest LPC news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/latest-lpc-news/" >View more LPC news ></a></p>
			<?php
			elseif(is_page("Funding and Statistics") || in_array(2489,$ancestors)) :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1, 'our-latest-news-category' => 'funding-and-statistics' ); ?>
				<div class="fs-news">
				<h2>Latest Funding &amp; Statistics news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/funding-and-statistics/" >View more Funding &amp; Statistics news ></a></p>
			<?php
			else :	
				$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => -1); ?>
				<div class="all-news">
				<h2>Latest news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/latest-news" >View more news ></a></p>
			<?php 
			endif;
			?>
			<!-- End conditional news items -->
					<div style="clear:both; height:10px; width:100%;"></div>
					<div class="slider4col">
					<?php
					$counter=0; // used to break the loop once 4 posts have been printed
					// use the conditional args set above for the loop
					$loop = new WP_Query( $args );
						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
						
							<?php // Check if post has expired
				
							$emptycheck = get_post_meta($post->ID, 'expiration_day' ,true); // only set variables if an expiry has been set
							$expiry = strtotime(get_post_meta($post->ID, 'expiration_year' ,true) . '-' . get_post_meta($post->ID, 'expiration_month' ,true) . '-' . get_post_meta($post->ID, 'expiration_day' ,true)); // convert expiry to unicode
							$now = date('U'); // get today's date as unicode
							
							if ($expiry > $now || empty($emptycheck)) :	// check if expiry date is in the future OR expiry date is empty ?>
	
								<!-- article -->
								<article id="post-<?php the_ID(); ?>"  class="news-box">
									<!-- post thumbnail -->
									<div class="news-thumb clear">
									<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php the_post_thumbnail('news-thumb'); ?>
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
									<?php html5wp_excerpt('html5wp_index'); ?>
									<?php edit_post_link(); ?>
								</article>
								<!-- /article -->
								
								<?php $counter++; // increment the counter ?>
								
							<?php else : // must mean content has expired ?>
							
								<!-- Don't display anything, don't increment the counter -->
								
							<?php endif; //end check for expiry ?>
							
							<?php if($counter == 4) : break; endif; // break the loop if 4 posts have been reached ?>

						<?php endwhile; endif; ?>
					</div>
					<!-- /slider4col -->
			
				</div>
				<!-- end specific news item wrap -->
		
		</div>
		<!-- /home-news-releases -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
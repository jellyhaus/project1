<?php
// redirect to the services database
$options = get_post_meta($_GET['formid'], 'awqsf-relbool', true);
if (isset($_GET['wqsfsubmit']) && $_GET['wqsfsubmit'] == $options[0]['button']) : get_template_part('search','services'); return; endif; ?>

<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
				</ul>
			</nav>
			<form id="search" name="searchform" method="get" action="<?php bloginfo("url"); ?>" style="border:1px solid #4e3487; padding:0 10px 10px 10px; margin-top:10px; clear: left; float: left; width: 100%;">
			<h2>Narrow your results</h2>
				<section>
					<label for="s2" style="font-weight:bold; line-height:2;">Keyword:</label><br>
					<input type="search" id="s2" name="s" title="Search Blog" value="<?php echo(get_search_query());?>" class="search-input filter" />
				</section>
				<br><label for="searchOptions" style="margin-top:10px; font-weight:bold; line-height:2;">Search in:</label><br>
				<section id="searchOptions">
					<select name="post_type" style="width:100%; margin-bottom:10px;">
						<option value="all" <?php if ($_GET['post_type'] == 'all') : echo 'selected'; endif; ?>>All content</option>
						<option value="page" <?php if ($_GET['post_type'] == 'page') : echo 'selected'; endif; ?>>Pages</option>
						<option value="our-latest-news" <?php if ($_GET['post_type'] == 'our-latest-news') : echo 'selected'; endif; ?>>Latest News</option>
						<option value="our-events" <?php if ($_GET['post_type'] == 'our-events') : echo 'selected'; endif; ?>>Events</option>
						<?php /* Check if main PSNC site */ $thisblog = get_current_blog_id(); if($thisblog == 1) : ?>
							<option value="our-publications" <?php if ($_GET['post_type'] == 'our-publications') : echo 'selected'; endif; ?>>Resources</option>
							<option value="our-services" <?php if ($_GET['post_type'] == 'our-services') : echo 'selected'; endif; ?>>Services</option>
						<?php endif; ?>
					</select>
				</section>
				
				
				
				<button type="submit" value="search" id="searchsubmit" class="purple-btn">Search</button>
			</form>
		</div>
		<!-- /sidebar-nav -->

		
		
		<div class="page-content search-page twelve columns">
			
			<?php
			
			$mySearch =& new WP_Query("s=$s & showposts=-1");
			
			
			if ($_GET['post_type'] == 'all') :
				$posttype = 'all content';
			elseif ($_GET['post_type'] == 'page') :
				$posttype = 'pages';
			elseif ($_GET['post_type'] == 'our-latest-news') :
				$posttype = 'latest news';
			elseif ($_GET['post_type'] == 'our-events') :
				$posttype = 'events';
			elseif ($_GET['post_type'] == 'our-services') :
				$posttype = 'services';
			elseif ($_GET['post_type'] == 'our-publications') :
				$posttype = 'resources';
			endif;
				
			?>
			
			<h1><?php echo $wp_query->found_posts; ?> search results for the keyword <span style="color: #c3137b;"><?php echo(get_search_query());?></span> in <span style="color: #c3137b;"><?php echo $posttype ?></span></h1>
			
			<?php get_template_part('pagination'); ?>
		

		
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
			<!-- check if the post has been excluded -->
			<?php 
			$exclude_from_search = get_post_meta($post->ID, 'exclude_from_search' ,true);
			if ($exclude_from_search != 'yes') :
			?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<div class="post-type">
						<?php 
						$post_type = get_post_type( $post->ID ); 
						if ($post_type == 'our-latest-news') : ?> 
							<img src="<?php echo get_template_directory_uri();?>/img/icons/news.png" alt="News"> 
						<?php elseif ($post_type == 'page') : ?> 
							<img src="<?php echo get_template_directory_uri();?>/img/icons/page.png" alt="Page"> 
						<?php elseif ($post_type == 'our-events') :  ?>
							<img src="<?php echo get_template_directory_uri();?>/img/icons/event.png" alt="Event">  
						<?php elseif ($post_type == 'our-services') :  ?>
							<img src="<?php echo get_template_directory_uri();?>/img/icons/service.png" alt="Service"> 
						<?php elseif ($post_type == 'our-publications') :  ?>
							<img src="<?php echo get_template_directory_uri();?>/img/icons/resource.png" alt="Resource">  
						<?php endif; ?>
					</div>
				
					<!-- post title -->
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>
					<!-- /post title -->
					
					<!-- post details -->
					<!-- <span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>-->
					
					<!-- /post details -->
					
					<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
	
					
				</article>
				<!-- /article -->
				
			<?php /* End check if exclude from search */ endif ; ?>
			
		<?php endwhile; ?>
		
		
		<?php else: ?>
		
			<!-- article -->
			<article>
				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
			</article>
			<!-- /article -->

			<?php endif; ?>

			

			
			<?php get_template_part('pagination'); ?>
	
		</div>
		<!-- /page-content -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
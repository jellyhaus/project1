<?php /* Template Name: Services Database Template */ get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
		
			<form method="get" id="awqsf_search_form_457" action="/service-search-results/" style="border:1px solid #65922e; padding:0 10px 10px 10px; clear: left; float: left; width: 100%;" >
				
				<h2>Search for a service</h2>
				
				<label>Location</label><br>
				
				<select id="location-of-service" name="location-of-service" style="max-width:100%">
					<option value="">All locations</option>
					<?php 
					$args1 = array('taxonomy' => 'location-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
					$categories=get_categories($args1); 
					foreach ($categories as $category) { ?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['location-of-service']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
					<?php } ?>
				</select>
				
				<br><br>
				
				<label>Type of service</label><br>
				<select id="type-of-service" name="type-of-service" style="max-width:100%">
					<option value="">All services</option>
					<?php 
					$args2 = array('taxonomy' => 'type-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
					$categories=get_categories($args2); 
					foreach ($categories as $category) { ?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['type-of-service']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
					<?php } ?> 
				</select>
				
				<br><br>
				
				<label>Method of commissioning</label><br>
				<select id="method-of-commissioning" name="method-of-commissioning" style="max-width:100%">
					<option value="">All methods</option>
					<?php 
					$args3 = array('taxonomy' => 'method-of-commissioning', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
					$categories=get_categories($args3); 
					foreach ($categories as $category) { ?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['method-of-commissioning']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
					<?php } ?> 
				</select>
				
				<br><br>
				
				<label>Funding source</label><br>
				<select id="funding-source" name="funding-source" style="max-width:100%">
					<option value="">All sources</option>
					<?php 
					$args4 = array('taxonomy' => 'funding-source', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
					$categories=get_categories($args4); 
					foreach ($categories as $category) { ?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['funding-source']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
					<?php } ?> 
				</select>
				
				<br><br>
				
				<!--<label for="se" style="line-height:2;">Keyword</label><br>
				<input id="se" type="text" name="se" value="" class="search-input services">-->
				
				<script type="text/javascript">
					jQuery(document).ready(function ($) {
						$('#reset').click(function () {
							$('#location-of-service').prop('selectedIndex',0);
							$('#type-of-service').prop('selectedIndex',0);
							$('#method-of-commissioning').prop('selectedIndex',0);
							$('#funding-source').prop('selectedIndex',0);
						});
					});
				</script>
				
				<p><a href="#" id="reset">Reset filters</a></p>
				
				<input type="submit" id="submit" value="Search" alt="[Submit]" name="wqsfsubmit" title="Search"  class="green-btn">
			
			</form>
			
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content services-database twelve columns clear">

			<h1>Services Database</h1> 
			
			<?php the_content(); ?>
			
			<!--
			
			<table class="services-table">
				<tr>
					<th>Title</th>
					<th>Location</th>
					<th>Status</th>
					<th>Start date</th>
				</tr>
				
			-->
	
			<?php
			
			/*
			 
			global $paged;
			$temp = $wp_query;
            $wp_query = null;
            $wp_query = new WP_Query( array('post_type' => 'our-services','posts_per_page' => -1, 'paged' => $paged ) );
			if (have_posts()): while (have_posts()) : the_post(); ?>
			
				<!-- article -->
				<tr id="post-<?php the_ID(); ?>"  class="service">
					<td><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></td>
					<td><?php $location_of_service = get_post_meta($post->ID, 'location_of_service' ,true); echo $location_of_service; ?></td>
					<td><?php $service_status = get_post_meta($post->ID, 'service_status' ,true); echo $service_status; ?></td>
					<td><?php $service_date_start = get_post_meta($post->ID, 'service_date_start' ,true); echo $service_date_start; ?></td>
				</tr>
				<!-- /article -->
							
			<?php endwhile; ?>
			
			<?php endif; ?>
			
			</table>
			
			<div class="pagination">
			
				<?php echo paginate_links( $args ) ?>
			    <?php
			    global $wp_query;
			
			    $big = 999999999; // need an unlikely integer
			
			    echo paginate_links( array(
			        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			        'format' => '?paged=%#%',
			        'current' => max( 1, get_query_var('paged') ),
			        'total' => $wp_query->max_num_pages
			    ) );
			    
			*/    
			    
			?>
		    
		    <!-- /pagination 
		    
			</div> -->

		</div>
		<!-- /page-content -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
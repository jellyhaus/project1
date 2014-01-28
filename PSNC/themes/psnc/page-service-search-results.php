<?php get_header(); ?>

<!-- Add current-menu-ancestor class to menu item -->
<script type="text/javascript">
	jQuery('.menu-services-and-commissioning').addClass('current-menu-ancestor');
</script>

	<div role="main" class="wrapper clear">
		
			<form method="get" id="awqsf_search_form_457" action="/service-search-results/" >
			
				<h1>Services Database search results</h1>
				
				<script type="text/javascript">
					jQuery(document).ready(function ($) {
						$('#reset').click(function () {
							$('#location-of-service').prop('selectedIndex',0);
							$('#type-of-service').prop('selectedIndex',0);
							$('#method-of-commissioning').prop('selectedIndex',0);
							$('#funding-source').prop('selectedIndex',0);
							return false;
						});
					});
				</script>
				
				<h2>Narrow your results <small><a href="#" id="reset">(Reset filters)</a></small></h2>
				
				<div class="four columns filter">
				
					<label style="float:left; margin-right:10px; margin-top:10px;">Location<br>
					
					<select id="location-of-service" name="location-of-service" style="max-width:100%">
						<option value="">All locations</option>
						<?php 
						$args1 = array('taxonomy' => 'location-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
						$categories=get_categories($args1); 
						foreach ($categories as $category) { ?>
							<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['location-of-service']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
						<?php } ?>
					</select>
					</label>
				
				</div><!-- /four columns -->
				
				<div class="four columns filter">
				
					<label style="float:left; margin-right:10px; margin-top:10px;">Type of service<br>
					<select id="type-of-service" name="type-of-service" style="max-width:100%">
						<option value="">All services</option>
						<?php 
						$args2 = array('taxonomy' => 'type-of-service', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
						$categories=get_categories($args2); 
						foreach ($categories as $category) { ?>
							<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['type-of-service']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
						<?php } ?> 
					</select>
					</label>
				
				</div><!-- /four columns -->
				
				<div class="four columns filter">
				
					<label style="float:left; margin-right:10px; margin-top:10px;">Method of commissioning<br>
					<select id="method-of-commissioning" name="method-of-commissioning" style="max-width:100%">
						<option value="">All methods</option>
						<?php 
						$args3 = array('taxonomy' => 'method-of-commissioning', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
						$categories=get_categories($args3); 
						foreach ($categories as $category) { ?>
							<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['method-of-commissioning']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
						<?php } ?> 
					</select>
					</label>
					
				</div><!-- /four columns -->
				
				<div class="four columns filter">
				
					<label style="float:left; margin-right:10px; margin-top:10px;">Funding source<br>
					<select id="funding-source" name="funding-source" style="max-width:100%">
						<option value="">All sources</option>
						<?php 
						$args4 = array('taxonomy' => 'funding-source', 'hierarchical' => true, 'echo' => '0', 'title_li' => '', 'hide_empty' => 0);
						$categories=get_categories($args4); 
						foreach ($categories as $category) { ?>
							<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $_GET['funding-source']) : echo 'selected'; endif;  ?>><?php echo $category->cat_name; ?></option>
						<?php } ?> 
					</select>
					</label>
				
				</div><!-- /four columns -->
				
				<div class="four columns">
				
					<input type="submit" id="submit" value="Filter" alt="[Submit]" name="wqsfsubmit" title="Search"  class="green-btn" style="width:auto; float:left; margin-right:10px; margin-top:10px; clear:none;">
				
				</div><!-- /four columns -->
			
			</form>
			
			<div class="clear" style="clear:both; width:100%;"></div>
		
		
		<div class="page-content services-database clear">

			 
			<p style="margin:20px 0; float:left;">Or enter a keyword below to further filter your search:</p>
			
			<div class="clear" style="clear:both; width:100%;"></div>
			
			<?php the_content(); ?>
			
			<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.dataTables.js"></script>
			
			<script type="text/javascript">
		
				jQuery(document).ready(function($) {
				    $('#services_tbl').dataTable( {
					    "sPaginationType": "full_numbers"
				    });
				} );
			
			</script>
			
			<table class="services-table" id="services_tbl">
				<thead>
					<tr>
						<th>Service ID</th>
						<th>Title</th>
						<th>Location</th>
						<th>Status</th>
						<th>Start date</th>
						<th style="display:none">content</th>
						<th>View</th>
					</tr>
				</thead>
				
				
			<?php
			
			if (!empty($_GET)) :
			
				$keyword = $_GET['se'];
			
				$args5 = array( 'post_type' => 'our-services', 'posts_per_page' => -1, 'orderby' => 'id', 'order' => 'ASC', 'type-of-service' => $_GET['type-of-service'], 'location-of-service' => $_GET['location-of-service'], 'method-of-commissioning' => $_GET['method-of-commissioning'], 'funding-source' => $_GET['funding-source']	);
		
				
				$query5 = new WP_Query( $args5 );
				
			else :
				
				$args5 =  array( 'post_type' => 'our-services', 'posts_per_page' => -1, 'orderby' => 'id', 'order' => 'ASC');
				$query5 = new WP_Query( $args5 );
			
			endif;
			
			
			  ?>

	
			<?php 
			if (have_posts()): while ($query5->have_posts()) : $query5->the_post(); ?>
			
				<!-- article -->
				<tr id="post-<?php the_ID(); ?>"  class="service">
					<td><?php echo $post->ID; ?></td>
					<td><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></td>
					<td><?php $location_of_service = strip_tags( get_the_term_list($post->ID, 'location-of-service') ); echo $location_of_service; ?></td>
					<td><?php $service_status = strip_tags( get_the_term_list($post->ID, 'service-status') ); echo $service_status; ?></td>
					<td><?php $service_date_start = get_post_meta($post->ID, 'service_date_start' ,true); echo $service_date_start; ?></td>
					<td style="display:none;"><?php echo (function_exists('ita_get_services_details')) ? ita_get_services_details($post->ID) : "" ;?></td>
					<td><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">View</a></td>
				</tr>
				<!-- /article -->
							
			<?php endwhile; ?>
			
			<?php endif; ?>
			
			<?php wp_reset_query(); ?>
			
			</table>

		</div>
		<!-- /page-content -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
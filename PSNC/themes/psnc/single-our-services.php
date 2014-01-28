<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
					<?php wp_list_pages('child_of=35&title_li=<a href="/services-commissioning/">Services and Commissioning</a>'); ?>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="single-service page-content twelve columns">
		
			<script>
			function goBack()
			  {
			  	window.history.back();
			  	return false;
			  }
			</script>
		
			<p style="margin-top: 20px;"><button type="button" value="Back" onclick="goBack()" class="green button">Back to results</button></p>

			<h1><?php the_title(); ?></h1>
			
			<hr style="height:0;">
	
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<h3>Service ID</h3>
					<p><?php the_ID(); ?></p>
				
					<h3>Description</h3>
					<div><?php $service_description = get_post_meta($post->ID, 'service_description' ,true); echo wpautop(stripslashes($service_description)); ?></div>
					
					<h3>Location of service</h3>
					<p><?php $location_of_service = strip_tags( get_the_term_list($post->ID, 'location-of-service') ); echo $location_of_service; ?></p>
					
					<h3>Commissioner</h3>
					<p><?php $service_commissioner = strip_tags( get_the_term_list($post->ID, 'service-commissioner') ); echo $service_commissioner; if ($service_commissioner == 'Other') : $other_commissioner = get_post_meta($post->ID, 'other_commissioner' ,true); echo ': ' . $other_commissioner; endif; ?></p>	
					
					<h3>Method of commissioning</h3>
					<p><?php $method_of_commissioning = strip_tags( get_the_term_list($post->ID, 'method-of-commissioning') ); echo $method_of_commissioning; ?></p>
					
					<h3>Source of funding</h3>
					<p><?php $source_of_funding = strip_tags( get_the_term_list($post->ID, 'funding-source') ); echo $source_of_funding; ?></p>	
					
					<h3>Service type</h3>
					<p><?php $service_type = strip_tags( get_the_term_list($post->ID, 'type-of-service') ); echo $service_type; ?></p>
					
					<?php if (is_user_logged_in()) : ?>
						<h3>Fee <span class="private">(Private)</span></h3>
						<p><?php $service_fee = get_post_meta($post->ID, 'service_fee' ,true); echo $service_fee; ?></p>
					<?php endif; ?>
					
					<h3>Other organisations involved</h3>
					<p><?php $service_other_organisations = get_post_meta($post->ID, 'service_other_organisations' ,true); echo wpautop($service_other_organisations); ?></p>
					
					<h3>Dates</h3>
					<p>
					Start date: <?php $service_date_start = get_post_meta($post->ID, 'service_date_start' ,true); echo $service_date_start;?><br>
					End date: <?php $service_date_end = get_post_meta($post->ID, 'service_date_end' ,true); echo $service_date_end; ?>
					</p>	
					
					<h3>Status</h3>
					<p><?php $service_status = strip_tags( get_the_term_list($post->ID, 'service-status') ); echo $service_status; ?></p>
					
					<h3>Training</h3>
					<div><?php $service_training = get_post_meta($post->ID, 'service_training' ,true); echo wpautop($service_training); ?></div>
					
					<h3>Comments</h3>
					<p><?php $service_comment = get_post_meta($post->ID, 'service_comment' ,true); echo wpautop($service_comment); ?></p>	
					
					<?php if (is_user_logged_in()) : ?>
					
						<h3>Contact details <span class="private">(Private)</span></h3>
						<p>
						<b>Name:</b> <?php $service_contact_name = get_post_meta($post->ID, 'service_contact_name' ,true); echo $service_contact_name; ?><br>
						<b>Email:</b> <?php $service_contact_email = get_post_meta($post->ID, 'service_contact_email' ,true); echo $service_contact_email; ?><br>
						<b>Telephone:</b> <?php $service_contact_tel = get_post_meta($post->ID, 'service_contact_tel' ,true); echo $service_contact_tel; ?><br>
						<b>Address:</b> <?php $service_contact_address = get_post_meta($post->ID, 'service_contact_address' ,true); echo wpautop($service_contact_address); ?><br>
						</p>	
						
						<h3>Documents <span class="private">(Private)</span></h3>
						<div class="documents">
							<?php $service_docs = get_post_meta($post->ID, 'service_docs' ,true); echo wpautop($service_docs); ?>
							<?php 

								$args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' =>'any', 'post_parent' => $post->ID ); 
								$attachments = get_posts( $args );
								
								if ( $attachments ) {
									foreach ( $attachments as $attachment ) {
										$the_link = wp_get_attachment_url( $attachment->ID);
										$att_title = $attachment->post_title;
										$att_id = $attachment->ID;
										echo '<p>';
										echo '<a href="'.$the_link.'" class="the_attachment">'.$att_title.'</a>';              
										echo '</p>';
									}
								} else {
									echo '<p>No files have been uploaded.</p>';
								} 
							?>
						</div>
						
						<h3>Evidence <span class="private">(Private)</span></h3>
						<div><?php $service_evaluation = get_post_meta($post->ID, 'service_evaluation' ,true); echo wpautop($service_evaluation); ?></div>
						
					<?php endif; ?>				

					
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
	
		</div>
		<!-- /page-content -->
		
		<hr>
	
		<div class="page-news-releases sixteen columns">
			<div class="sc-news">
				<h2>Latest Services and Commissioning news</h2>
				<p class="view-more"><a href="<?php echo get_bloginfo("url"); ?>/our-latest-news-category/services-commissioning/" >View more Services and Commissioning news ></a></p>
				<div class="clear"></div>

					<div class="slider4col">
					<?php
					$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => 12, 'our-latest-news-category' => 'services-commissioning' );
					$loop = new WP_Query( $args );

						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
							<!-- article -->
							
							<!-- check if expired -->
							<?php 
								$expirationtime = get_post_custom_values('content_expiration'); 
								if (is_array($expirationtime)) :
									$expirestring = implode($expirationtime);
								endif;
								$secondsbetween = strtotime($expirestring)-time();
								if ( $secondsbetween > 0 ) :	
							?>
							<article id="post-<?php the_ID(); ?>"  class="news-box">
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
						<?php endwhile; ?>
						<?php else: ?>
							<!-- article -->
							<article>
								<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
							</article>
							<!-- /article -->
						<?php endif; ?>
					</div>
					<!-- /slider4col -->
			</div>
			<!-- /sc-news -->
		</div>
		<!-- /home-news-releases -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
			<?php if (!is_home()) : ?>
				<section class="footer-news wrapper clear">
				
					<div class="lpc-news column">
						<h2><a href="<?php echo home_url(); ?>/latest-news/">LPC News</a></h2>
						<?php 
						$args = array( 'post_type' => 'our-latest-news', 'posts_per_page' => 2 );
						$loop = new WP_Query( $args );
						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
				
							<!-- article -->
							<article id="post-<?php the_ID(); ?>"  class="">
								
								<!-- post title -->
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- /post title -->
								
								<?php html5wp_excerpt('html5wp_index'); ?>

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
					<!-- /lpc-news -->
				
					<div class="psnc-news column">
						<h2><a href="/latest-news/">PSNC News</a></h2>
						<?php
                        global $switched;
                        switch_to_blog(1); //switched to 2 ?>

                        <?php 
						$args = array( 'post_type' => 'our-latest-news ', 'posts_per_page' => 2 );
						$loop = new WP_Query( $args );
						if (have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
				
							<!-- article -->
							<article id="post-<?php the_ID(); ?>">
								
								<!-- post title -->
								<h3>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<!-- /post title -->
								
								<?php html5wp_excerpt('html5wp_index'); ?>
	
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
					<!-- /psnc-news -->
					
					
				</section>
				<!-- /footer-news -->
				
			<?php endif; ?>
			
			<!-- footer -->
			<footer class="footer" role="contentinfo" <?php if (is_home()) : ?>style="margin-top:30px;"<?php endif; ?>>
				
				<div class="wrapper clear">
					
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) :  ?>
					<?php else : ?>
					<?php endif; ?>
					
					<hr class="hrwhite">
					
					<div class="footer-credits">
						<p>Copyright &copy; <?php echo date("Y"); ?> PSNC &bull; Site designed and built by <a href="http://www.jellyhaus.com" target="_blank">Jellyhaus</a></p>
					</div>

				
				</div>
				<!-- /wrapper -->
				
			</footer>
			<!-- /footer -->


		<script>
			
		</script>
		<div id="home-url" style="display:none;"><?php echo home_url(); ?></div>
		<?php wp_footer(); ?>

	</body>
</html>
<!-- This template is only in place to catch any erroneous indexed categories from within the search engines -->
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
									$(".sidebar-nav ul li.categories").hide();
									$(".show-hide.sidebar a").click(function(){
										$('.sidebar-nav ul li.categories').slideToggle("fast");
										$(this).toggleClass("open");
										return false;
									});
								}
							});
						</script>
						<div class="show-hide sidebar mobileelement"><a href="#">Show/Hide all Events Categories</a></div>
					</li>
					<li class="categories"><a href="#" onclick="return false;" style="cursor: text; background:grey; color:white;">Categories:</a>
						<ul>
						<?php
						$args_list = array(
							'hierarchical' => true,
							'echo' => '0',
							'title_li' => ''
						);	 
						echo wp_list_categories($args_list);
						?>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">

			<h1><?php the_category(); ?></h1>
	
			<?php get_template_part('loop'); ?>
			
			<?php get_template_part('pagination'); ?>
	
		</div>
		<!-- /page-content -->

	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
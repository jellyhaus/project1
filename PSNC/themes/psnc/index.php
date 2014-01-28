<!-- This template isn't used within the site - here only as a fallback -->
<?php get_header(); ?>

	<div role="main" class="wrapper clear">
	
		<div class="sidebar-nav four columns">
			<?php $parent_page = get_top_parent_page_id($post->ID); $parent_page_title = get_the_title($parent_page); $parent_page_uri = get_page_uri($parent_page); ?>
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>" class="back-home">Home</a></li>
					<?php wp_list_pages("child_of=$parent_page&title_li=<a href=\"$parent_page_uri\" class=\"parent-page\">$parent_page_title</a>"); ?>
				</ul>
			</nav>
		</div>
		<!-- /sidebar-nav -->
		
		
		<div class="page-content twelve columns">

			<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>
	
			<?php get_template_part('loop'); ?>
			
			<?php get_template_part('pagination'); ?>
	
		</div>
		<!-- /page-content -->
	
	</div>
	<!-- /wrapper -->

<?php get_footer(); ?>
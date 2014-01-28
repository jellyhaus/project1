			<!-- footer -->
			<div style="clear:both; width:100%;"></div>
			<footer class="footer" role="contentinfo" <?php if (is_home()) : ?>style="margin-top:30px;"<?php endif; ?>>
				
				<div class="wrapper clear">
					
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
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
		<?php wp_footer(); ?>
	
	</body>
</html>
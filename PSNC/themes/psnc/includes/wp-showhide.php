<?php
//toggle shortcode
 function toggle_shortcode( $atts, $content = null ) {
	 extract( shortcode_atts(
	 array(
		 'title' => 'Click To Open',
		 'closed' => 'yes',
		 'heading' => 'h2'
	 ),
	 $atts ) );
	 return '<' . $heading . ' class="trigger">'. $title . '</' . $heading . '><div class="toggle_container">' . do_shortcode($content) . '</div>';
 }
 add_shortcode('showhide', 'toggle_shortcode');
 
 
add_action('wp_footer', 'showhide_footer');
function showhide_footer() {
	echo '<script type="text/javascript">'."\n";
	echo '/* <![CDATA[ */'."\n";
	echo 'jQuery(document).ready(function () {'."\n";
	echo 'jQuery(".toggle_container").hide();'."\n";
	echo 'jQuery(".trigger").click(function(){';
	echo 'jQuery(this).toggleClass("active").next().toggle();'."\n";
	echo 'return false;'."\n";
	echo '});'."\n";
	echo '});'."\n";
	echo '/* ]]> */'."\n";
	echo '</script>'."\n";
}
?>
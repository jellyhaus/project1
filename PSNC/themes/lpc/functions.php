<?php

// Disable theme switching

add_filter( 'all_themes', 'wpse_55081_remove_themes_ms' );
function wpse_55081_remove_themes_ms($themes)
{
    unset($themes['psnc']);
    return $themes;
}

function remove_psnc_actions() {
    remove_action( 'admin_head', 'cpt_icons' );
}
add_action('init','remove_psnc_actions');

add_action( 'admin_menu', 'remove_psnc_cpt' );

	function remove_psnc_cpt() {
		remove_menu_page('edit.php?post_type=our-services');
		remove_menu_page('edit.php?post_type=our-publications');
		remove_menu_page('edit.php?post_type=psnc-ads');
	}

// custom nav menus



// custom menu styling
?>
<?php
add_action( 'admin_head', 'lpc_admin' );
function lpc_admin() {
    ?>
    <style type="text/css" media="screen">
    /* icons */
    #menu-posts-our-latest-news .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-news.png) no-repeat 0 0 !important;}
	#menu-posts-our-latest-news:hover .wp-menu-image, #menu-posts-our-latest-news.wp-has-current-submenu .wp-menu-image {background-position:0 -28px!important;}
	
	#menu-posts-our-services .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-services.png) no-repeat 0 0 !important;}
	#menu-posts-our-services:hover .wp-menu-image, #menu-posts-our-services.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	#menu-posts-our-publications .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-publications.png) no-repeat 0 0 !important;}
	#menu-posts-our-publications:hover .wp-menu-image, #menu-posts-our-publications.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	#menu-posts-our-events .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-events.png) no-repeat 0 0 !important;}
	#menu-posts-our-events:hover .wp-menu-image, #menu-posts-our-events.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	#menu-posts-menu-feature .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-dropdown.png) no-repeat 0 0 !important;}
	#menu-posts-menu-feature:hover .wp-menu-image, #menu-posts-menu-feature.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	#menu-posts-feature .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-featured.png) no-repeat 0 0 !important;}
	#menu-posts-feature:hover .wp-menu-image, #menu-posts-feature.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	#menu-posts-psnc-ads .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/img/icons/admin-banner-ads.png) no-repeat 0 0 !important;}
	#menu-posts-psnc-ads:hover .wp-menu-image, #menu-posts-psnc-ads.wp-has-current-submenu .wp-menu-image {background-position:0 -28px !important;}
	
	
	#adminmenuback, #adminmenuwrap {background-color: #f8e5cc;}
	#wpadminbar {background:#d58721 ; /* DEV  background: red;*/}
	a, #adminmenu a, #the-comment-list p.comment-author strong a, #media-upload a.del-link, #media-items a.delete, #media-items a.delete-permanently, .plugins a.delete, .ui-tabs-nav a {color: #d58721;}
	#wpadminbar * {color: #fff; text-shadow: none;}
	#adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li.menu-top:focus {color:#d58721;}
	#wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a {color: #d58721;}
	#wpadminbar .quicklinks li div.blavatar {background: none !important;}
	#logo a {background: none !important;}
	li#wp-admin-bar-new-content {background: black !important;}
	.scottsweb-credit {display:none;}
	#toplevel_page_ckeditor_settings { display: none; }
	.toplevel_page_awqsf { display: none; }

    </style>
<?php } ?>
<?php
// footer
if ( function_exists('register_sidebar') ) {
   register_sidebar(array(
       'name'=>'Home Page Utility',
       'before_widget' => '<div id="%1$s" class="clear %2$s">',
       'after_widget' => '</div>',
       'before_title' => '<h2 class="widgettitle">',
       'after_title' => '</h2>',
   ));
}

// lpc regions widget

class lpc_regions extends WP_Widget {
          function lpc_regions() {
                    $widget_ops = array(
                    'classname' => 'lpc_regions',
                    'description' => 'A small widget linking to the LPC regions page'
          );
          $this->WP_Widget(
                    'lpc_regions',
                    'LPC Regions',
                    $widget_ops
          );
}
          function widget($args, $instance) { // widget sidebar output
                    extract($args, EXTR_SKIP);
                    echo $before_widget; // pre-widget code from theme
                    echo ('<h3>Visit the LPC portal</h3><a href="http://www.lpc-online.org.uk"><img src="');
                    echo get_stylesheet_directory_uri();
                    echo ('/img/lpc-footer-map.png" alt="LPC Regions" class="logo-img" style="margin-left: 40px;"></a>');
                    echo $after_widget; // post-widget code from theme
          }
}
add_action(
          'widgets_init',
          create_function('','return register_widget("lpc_regions");')
);

// hide welcome panel

if ( ! defined( 'ABSPATH' ) || ! is_multisite() )
	return;

add_action( 'load-index.php', 'nacin_hide_welcome_panel_for_multisite' );

function nacin_hide_welcome_panel_for_multisite() {
	$user_id = get_current_user_id();

	if ( 2 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
}

// custom theme settings

function lpc_theme_customizer( $wp_customize ) {
    
    // logo
    $wp_customize->add_section( 'lpc_logo_section' , array(
    'title'       => __( 'Custom logo', 'lpc' ),
    'priority'    => 30,
    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );
	$wp_customize->add_setting( 'lpc_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lpc_logo', array(
	    'label'    => __( 'Custom logo', 'lpc' ),
	    'section'  => 'lpc_logo_section',
	    'settings' => 'lpc_logo',
	) ) );
	
	}

	
add_action('customize_register', 'lpc_theme_customizer');


?>
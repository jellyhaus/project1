<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	Prevent editing of 'jellyhaus' user and other access restrictions
\*------------------------------------*/

add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
  global $current_user;
  $username = $current_user->user_login;

  if ($username != 'jellyhaus' ) { 
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'jellyhaus'",$user_search->query_where);
  }
}

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/







/*------------------------------------*\
	Theme Support
\*------------------------------------*/

// Create About us page by default

function wpse_71863_default_pages( $blog_id )
{
    $default_pages = array(
        'About us'
    );

    switch_to_blog( $blog_id );

    if ( $current_pages = get_pages() )
        $default_pages = array_diff( $default_pages, wp_list_pluck( $current_pages, 'post_title' ) );

    foreach ( $default_pages as $page_title ) {        
        $data = array(
            'post_title'   => $page_title,
            'post_content' => "This is my $page_title page.",
            'post_status'  => 'publish',
            'post_type'    => 'page',
        );

        wp_insert_post( add_magic_quotes( $data ) );
    }

    restore_current_blog();
}

add_action( 'wpmu_new_blog', 'wpse_71863_default_pages' );

// Delete Sample page by default
function lu_death_to_sample_page($blog_id, $user_id) {
	switch_to_blog($blog_id);
	
	wp_delete_post(2, true); //post ID 2 should be the sample page
	
	restore_current_blog();
}
add_action('wpmu_new_blog', 'lu_death_to_sample_page', 10, 2);


if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('slideshow-size', 528, 260, true); // Slideshow
    add_image_size('news-thumb', 300, 115, true);
    add_image_size('square', 200, 200, true); // Square

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

if ( function_exists('register_sidebar') ) {
   register_sidebar(array(
       'name'=>'Footer',
       'before_widget' => '<div id="%1$s" class="four columns clear %2$s">',
       'after_widget' => '</div>',
       'before_title' => '<h3 class="widgettitle">',
       'after_title' => '</h3>',
   ));
}

// remove default widgets

 function unregister_default_widgets() {
     unregister_widget('WP_Widget_Pages');
     unregister_widget('WP_Widget_Calendar');
     unregister_widget('WP_Widget_Archives');
     unregister_widget('WP_Widget_Meta');
     unregister_widget('WP_Widget_Search');
     unregister_widget('WP_Widget_Categories');
     unregister_widget('WP_Widget_Recent_Posts');
     unregister_widget('WP_Widget_Recent_Comments');
     unregister_widget('WP_Widget_RSS');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);

/*
Add missing TinyMCE buttons
*/
function my_mce_buttons_3($buttons) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'anchor';
	$buttons[] = 'hr';
	$buttons[] = 'replace';
	$buttons[] = 'formatselect';

	return $buttons;
}
add_filter('mce_buttons_3', 'my_mce_buttons_3');

/* remove 'more' button*/
function make_mce_awesome( $init ) {
    $init['theme_advanced_disable'] = 'wp_more, media, wp_page, image';
    return $init;
}
add_filter('tiny_mce_before_init', 'make_mce_awesome');

/* Filter out unwanted pages from search */

function jp_search_filter( $query ) {
  if ( $query->is_search && $query->is_main_query() ) {
    $query->set( 'post__not_in', array( 458,11,20,105 ) );
  }
}
add_filter( 'pre_get_posts', 'jp_search_filter' );

// oEmbed
wp_embed_register_handler( 'google_map', '#https://maps\.google\.co\.uk/maps(.*)#i', 'embed_google_map' );
function embed_google_map( $matches ) {
	$query = parse_url($matches[0]);
    parse_str($query['query'], $qvars);
	$width = isset($qvars['w']) ? $qvars['w'] : '100%';
	$height = isset($qvars['w']) ? $qvars['h'] : 450;
	$embed = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$matches[0].'"></iframe>';
	return apply_filters( 'embed_g_map', $embed );
}
wp_embed_register_handler( 'google_cal', '#http://www\.google\.com/calendar(.*)#i', 'embed_google_cal' );
function embed_google_cal( $matches ) {
	$query = parse_url($matches[0]);
    parse_str($query['query'], $qvars);
	$width = isset($qvars['w']) ? $qvars['w'] : '100%';
	$height = isset($qvars['w']) ? $qvars['h'] : 500;
	$embed = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$matches[0].'"></iframe>';
	return apply_filters( 'embed_g_map', $embed );
}

// Added to extend allowed files types in Media upload 
add_filter('upload_mimes', 'custom_upload_mimes'); 
function custom_upload_mimes ( $existing_mimes=array() ) { 
	$existing_mimes['eps'] = 'application/postscript'; 
	$existing_mimes['ai'] = 'application/postscript'; 
	return $existing_mimes; 
}


 
/*------------------------------------*\
	Custom nav menus
\*------------------------------------*/

function register_my_menus() {
  register_nav_menus(
    array(
      'quick-links-menu' => __( 'Quick Links Menu' ),
      'main-menu' => __( 'Main Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"child-menu\">\n";
  }
}

// add class to pagination

add_filter('next_posts_link_attributes', 'posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'posts_link_attributes_2');

function posts_link_attributes_1() {
    return 'class="prev-post"';
}
function posts_link_attributes_2() {
    return 'class="next-post"';
}

// Show private pages in admin dropdown

add_filter( 'page_attributes_dropdown_pages_args', 'wps_dropdown_pages_args_add_parents' );
add_filter( 'quick_edit_dropdown_pages_args', 'wps_dropdown_pages_args_add_parents' );
/**
 * Add private/draft/future/pending pages to parent dropdown.
 */
function wps_dropdown_pages_args_add_parents( $dropdown_args, $post = NULL ) {
    $dropdown_args['post_status'] = array( 'publish', 'private' );
    // $dropdown_args['post_status'] = array( 'publish', 'draft', 'pending', 'future', 'private', );
    return $dropdown_args;
}

// Rename Private and Protected pages

function the_title_trim($title) {

	$title = attribute_escape($title);

	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);

	$replacewith = array(
		"<span style='color:#d58721'>LPC Members' Area:</span>", // What to replace "Protected:" with
		"<span style='color:#d58721'>LPC Members' Area:</span>" // What to replace "Private:" with
	);

	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');

// Featured menu item

/*class Featured_Item_Walker extends Walker_Nav_Menu
{

 function start_el(&$output, $item, $depth, $args)
 {
    $classes     = empty ( $item->classes ) ? array () : (array) $item->classes;

    $class_names = join(
        ' '
    ,   apply_filters(
            'nav_menu_css_class'
        ,   array_filter( $classes ), $item
        )
    );

    ! empty ( $class_names )
        and $class_names = ' class="'. esc_attr( $class_names ) . '"';

    $output .= "<li id='menu-item-$item->ID' $class_names>";

    $attributes  = '';

    ! empty( $item->attr_title )
        and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
    ! empty( $item->target )
        and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
    ! empty( $item->xfn )
        and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
    ! empty( $item->url )
        and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

    // insert thumbnail
    // you may change this
    $thumbnail = '';
    if( $id = has_post_thumbnail( (int)$item->object_id ) ) {
        $thumbnail = get_the_post_thumbnail( $id );
    }

    $title = apply_filters( 'the_title', $item->title, $item->ID );

    $item_output = $args->before
        . "<a $attributes>"
        . $args->link_before
        . $title
        . '</a> '
        . $args->link_after
        . $thumbnail
        . $args->after;

    // Since $output is called by reference we don't need to return anything.
    $output .= apply_filters(
        'walker_nav_menu_start_el'
    ,   $item_output
    ,   $item
    ,   $depth
    ,   $args
    );
   }
}*/

// Breadcrumb

function the_breadcrumbs() {

        global $post;

        if (!is_home()) {

            echo "<a href='";
            echo get_option('home');
            echo "'>";
            echo "Home";
            echo "</a>";

            if (is_category() || is_single()) {

                echo " > ";
                $cats = get_the_category( $post->ID );

                foreach ( $cats as $cat ){
                    echo $cat->cat_name;
                    echo " > ";
                }
                if (is_single()) {
                    the_title();
                }
            } elseif (is_page()) {

                if($post->post_parent){
                    $anc = get_post_ancestors( $post->ID );
                    $anc_link = get_page_link( $post->post_parent );

                    foreach ( $anc as $ancestor ) {
                        $output = " > <a href=".$anc_link.">".get_the_title($ancestor)."</a> > ";
                    }

                    echo $output;
                    the_title();

                } else {
                    echo ' > ';
                    echo the_title();
                }
            }
        }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"Archive: "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"Archive: "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"Archive: "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"Author's archive: "; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blogarchive: "; echo'

';}
    elseif (is_search()) {echo"Search results: "; }
}

/***********************************
*
* SEARCH FILTER
* http://dbaines.com/blog/archive/wordpress-custom-post-type-multiple-search/
*
***********************************/
function SearchFilter($query) {
if ($query->is_search) {

if($_GET['post_type'] == 'page') {
$query->set('post_type', 'page');
}

elseif($_GET['post_type'] == 'our-latest-news') {
$query->set('post_type', 'our-latest-news');
}

elseif($_GET['post_type'] == 'our-events') {
$query->set('post_type', 'our-events');
}

elseif($_GET['post_type'] == 'our-services') {
$query->set('post_type', 'our-services');
}

elseif($_GET['post_type'] == 'our-publications') {
$query->set('post_type', 'our-publications');
}

elseif($_GET['post_type'] == 'all') {
$query->set('post_type', array('our-latest-news', 'page', 'our-events', 'our-publications', 'our-services'));
}
}
return $query;
}
// This filter will jump into the loop and arrange our results before they're returned
add_filter('pre_get_posts','SearchFilter');




/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

function create_post_type_html5()
{
	// News items
    register_post_type('our-latest-news', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Latest News'), // Rename these to suit
            'all_items' => __( 'All Latest News' ),
            'singular_name' => __('Latest News item'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add new Latest News item'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Latest News item'),
            'new_item' => __('New Latest News item'),
            'view' => __('View Latest News item'),
            'view_item' => __('View Latest News item'),
            'search_items' => __('Search Latest News items'),
            'not_found' => __('No Latest News items found'),
            'not_found_in_trash' => __('No Latest News items found in Trash')
        ),
        'public' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite' => array('slug' => 'our-news'),
        'can_export' => true
    ));
    
    // Publications
    register_post_type('our-publications', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Publications'), // Rename these to suit
            'all_items' => __( 'All Publications' ),
            'singular_name' => __('Publication'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add new Publication'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Publication'),
            'new_item' => __('New Publication'),
            'view' => __('View Publications'),
            'view_item' => __('View Publication'),
            'search_items' => __('Search Publications'),
            'not_found' => __('No Publications found'),
            'not_found_in_trash' => __('No Publications found in Trash')
        ),
        'public' => true,
        'rewrite' => array('slug' => 'our-publications'),
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true // Add Category and Post Tags support
    ));
    
    // Services
    register_post_type('our-services', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Services'), // Rename these to suit
            'all_items' => __( 'All Services' ),
            'singular_name' => __('Service'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add new Service'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Service'),
            'new_item' => __('New Service'),
            'view' => __('View Services'),
            'view_item' => __('View Service'),
            'search_items' => __('Search Services'),
            'not_found' => __('No Services found'),
            'not_found_in_trash' => __('No Services found in Trash')
        ),
        'public' => true,
        'rewrite' => array('slug' => 'our-services'),
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true
    ));
    
    // Events
    register_post_type('our-events', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Events'), // Rename these to suit
            'all_items' => __( 'All Events' ),
            'singular_name' => __('Event'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add new Event'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Event'),
            'new_item' => __('New Event'),
            'view' => __('View Event'),
            'view_item' => __('View Event'),
            'search_items' => __('Search Events'),
            'not_found' => __('No Events found'),
            'not_found_in_trash' => __('No Events found in Trash')
        ),
        'public' => true,
        'rewrite' => array('slug' => 'our-events'),
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true
    ));
    
    // Menu feature
    register_post_type('menu-feature', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Dropdown Menu Features'), // Rename these to suit
            'all_items' => __( 'All Dropdown Menu Features' ),
            'singular_name' => __('Dropdown Menu Feature'),
            'add_new' => __('Add New Dropdown Menu Feature'),
            'add_new_item' => __('Add New Dropdown Menu Feature'),
            'edit' => __('Edit Dropdown Menu Feature'),
            'edit_item' => __('Edit Dropdown Menu Feature'),
            'new_item' => __('New Dropdown Menu Feature'),
            'view' => __('View Dropdown Menu Feature'),
            'view_item' => __('View Dropdown Menu Feature'),
            'search_items' => __('Search Dropdown Menu Features'),
            'not_found' => __('No Dropdown Menu Features found'),
            'not_found_in_trash' => __('No Dropdown Menu Features found in Trash')
        ),
        'public' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'page-attributes'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true
    ));
    
    // Home page slideshow
    register_post_type('feature',
    	array(
	    'labels' => array(
	           'name' => __( 'Featured Slides' ),
	           'singular_name' => __( 'Featured Slide' ),
	           'add_new' => __( 'Add New Featured Slide' ),
	           'add_new_item' => __( 'Add New Featured Slide' ),
	           'edit_item' => __( 'Edit Featured Slide' ),
	           'new_item' => __( 'Add New Featured Slide' ),
	           'view_item' => __( 'View Featured Slide' ),
	           'search_items' => __( 'Search Featured Slides' ),
	           'not_found' => __( 'No Featured Slides found' ),
	           'not_found_in_trash' => __( 'No Featured Slides found in trash' )
	     ),
	     'public' => true,
	     'show_ui' => true,
	     'capability_type' => 'post',
	     'hierarchical' => false,
	     'rewrite' => true,
	     'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
	  ));
	  
	  // Ads
    register_post_type('psnc-ads',
    	array(
	    'labels' => array(
	           'name' => __( 'Banner Ads' ),
	           'singular_name' => __( 'Banner Ad' ),
	           'add_new' => __( 'Add New Banner Ad' ),
	           'add_new_item' => __( 'Add New Banner Ad' ),
	           'edit_item' => __( 'Edit Banner Ad' ),
	           'new_item' => __( 'Add New Banner Ad' ),
	           'view_item' => __( 'View Banner Ad' ),
	           'search_items' => __( 'Search Banner Ads' ),
	           'not_found' => __( 'No Banner Ads found' ),
	           'not_found_in_trash' => __( 'No Banner Ads found in trash' )
	     ),
	     'public' => true,
	     'show_ui' => true,
	     'capability_type' => 'post',
	     'hierarchical' => false,
	     'rewrite' => true,
	     'supports' => array('title', 'editor')
	  ));
	  
}

// Create the taxonomies

add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
   
    // news categories
    register_taxonomy(
        'our-latest-news-category',
        'our-latest-news',
        array(
            'labels' => array(
                'name' => 'News Categories',
                'add_new_item' => 'Add New News Category',
                'new_item_name' => "New News Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
    
    // news tags
    /*
    register_taxonomy(
        'our-latest-news-tag',
        'our-latest-news',
        array(
            'labels' => array(
                'name' => 'News Tags',
                'add_new_item' => 'Add New News Tag',
                'new_item_name' => "New News Tag"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => false
        )
    );
    */
    
    // services categories
    register_taxonomy(
        'our-services-category',
        'our-services',
        array(
            'labels' => array(
                'name' => 'Service Categories',
                'add_new_item' => 'Add New Service Category',
                'new_item_name' => "New Service Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => true
        )
    );
    function remove_services_meta() {
	remove_meta_box( 'our-services-categorydiv', 'our-services', 'side' );
	}
	add_action( 'admin_menu' , 'remove_services_meta' );
    
    // events categories
    register_taxonomy(
        'our-events-category',
        'our-events',
        array(
            'labels' => array(
                'name' => 'Events Categories',
                'add_new_item' => 'Add New Event Category',
                'new_item_name' => "New Event Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
    
    // events tags
    /*
    register_taxonomy(
        'our-events-tag',
        'our-events',
        array(
            'labels' => array(
                'name' => 'Events Tags',
                'add_new_item' => 'Add New Event Tag',
                'new_item_name' => "New Event Tag"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => false
        )
    );
    */
    
    // media categories
    register_taxonomy(
        'media-category',
        'attachment',
        array(
            'labels' => array(
                'name' => 'Media Categories',
                'add_new_item' => 'Add New Media Category',
                'new_item_name' => "New Media Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'show_admin_column' => true
        )
    );
}

// Media categories filter dropdown


add_action('restrict_manage_posts','restrict_media_by_category');
function restrict_media_by_category() {
    $screen = get_current_screen();
    global $wp_query;
    if ('upload' == $screen->id ) {
    $taxonomy = 'media-category';
    $term = isset($wp_query->query['media-category']) ? $wp_query->query['media-category'] :'';
    $business_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' =>  __("Show All"),
            'taxonomy'        =>  $taxonomy,
            'name'            =>  'media-category',
            'orderby'         =>  'name',
            'selected'        =>  $term,
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true, // Show # listings in parens
            'hide_empty'      =>  false, // Don't show categories w/o listings
        ));
    }
}
if(is_admin()) {
	add_filter('parse_query','convert_category_id_to_taxonomy_term_in_query');
	function convert_category_id_to_taxonomy_term_in_query($query) {
	    $screen = get_current_screen();
	    $qv = &$query->query_vars;
	    if ('upload' == $screen->id && isset($qv['media-category']) && is_numeric($qv['media-category'])) {
	        $term = get_term_by('id',$qv['media-category'],'media-category');
	        $qv['media-category'] = ($term ? $term->slug : '');
	    }
	}
}


// Filter media by type
// http://wp.tutsplus.com/articles/tips-articles/quick-tip-add-extra-media-type-filters-to-the-wordpress-media-manager/



// Add Filter Hook
add_filter( 'post_mime_types', 'modify_post_mime_types' );


function modify_post_mime_types($post_mime_types) {
	$post_mime_types['application/pdf'] = array(
							__('PDFs'),
							__('Manage PDFs'),
							_n_noop('PDFs (%s)', 'PDFs (%s)')
							);

	$post_mime_types['application/msword'] = array(
							__('DOC'),
							__('Manage DOCs'),
							_n_noop('DOCs (%s)', 'DOCs (%s)')
							);
	return $post_mime_types;
}

add_filter('post_mime_types', 'modify_post_mime_types');



/* For adding custom field to gallery popup */
function add_image_attachment_fields_to_edit($form_fields, $post) {
  // $form_fields is a an array of fields to include in the attachment form
  // $post is nothing but attachment record in the database
  //     $post->post_type == 'attachment'
  // attachments are considered as posts in WordPress. So value of post_type in wp_posts table will be attachment
  // now add our custom field to the $form_fields array
  // input type="text" name/id="attachments[$attachment->ID][custom1]"
  $form_fields["credit"] = array(
    "label" => __("Credit"),
    "input" => "text", // this is default if "input" is omitted
    "value" => get_post_meta($post->ID, "_credit", true),
                "helps" => __("Help string."),
  );
   return $form_fields;
}
// now attach our function to the hook
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);

function add_image_attachment_fields_to_save($post, $attachment) {
  // $attachment part of the form $_POST ($_POST[attachments][postID])
        // $post['post_type'] == 'attachment'
  if( isset($attachment['credit']) ){
    // update_post_meta(postID, meta_key, meta_value);
    update_post_meta($post['ID'], '_credit', $attachment['credit']);
  }
  return $post;
}
// now attach our function to the hook.
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);




/*------------------------------------*\
	Custom fields
\*------------------------------------*/

// Services database
require_once ( TEMPLATEPATH. '/services-database.php' );

// Insert the meta boxes
function add_custom_meta_box() {
    // event details into events CPT
    add_meta_box(
		'event_details', // $id
		'Event Details', // $title 
		'event_details_meta_box', // $callback
		'our-events', // $page
		'normal', // $context
		'default'); // $priority
	// Link to page into Featured Slider
	add_meta_box( 
		'my-meta-box-id', 
		'Link to Page', 
		'cd_meta_box_cb', 
		'feature', 
		'normal', 
		'high' );
	// Link to page into menu features
	add_meta_box( 
		'my-meta-box-id', 
		'Link to Page', 
		'cd_meta_box_cb', 
		'menu-feature', 
		'normal', 
		'high' );
	// List of current pages
	add_meta_box( 
		'list_of_pages', 
		'Location', 
		'list_of_pages_meta', 
		'psnc-ads', 
		'normal', 
		'high' );
	// Exclude from search
	foreach ( array( 'post', 'page', 'our-latest-news', 'our-events', 'our-services' ) as $page )
    add_meta_box( 
		'exclude_from_search', 
		'Exclude from Search?', 
		'exclude_from_search_meta', 
		$page, 
		'side', 
		'default' );
	// Expire
	foreach ( array( 'post', 'page', 'our-latest-news', 'our-events', 'our-services' ) as $page2 )
    add_meta_box( 
		'content_expiration', 
		'Content expiration date', 
		'content_expiration_meta', 
		$page2, 
		'side', 
		'default' );
	// SEO Description
	foreach ( array( 'post', 'page', 'our-latest-news', 'our-events', 'our-services' ) as $page3 )
    add_meta_box( 
		'seo_description', 
		'Search Engine Description', 
		'seo_description_meta', 
		$page3, 
		'normal', 
		'default' );
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// 1. Event details
function event_details_meta_box($post) {
	$values = get_post_custom( $post->ID );
	$event_date = isset( $values['event_date'] ) ? esc_attr( $values['event_date'][0] ) : '';
	$event_location = isset( $values['event_location'] ) ? esc_attr( $values['event_location'][0] ) : '';
	$event_time = isset( $values['event_time'] ) ? esc_attr( $values['event_time'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script>
	  jQuery(function() {
	    jQuery( ".datepicker" ).datepicker({
			
	    	dateFormat:'dd-mm-yy',
	    	showOn: "button",
	    	buttonImage: "/wp-content/themes/psnc/img/calendar.gif",
      		buttonImageOnly: true
	    	});
	  });
	  </script>
	<p>
	<style>.ui-datepicker-year {display: inline;}</style>
	<label for="event_date" style="width:100px;">Event date</label>
	<input type="text" name="event_date" id="event_date" value="<?php if (!empty($event_date)) { echo date("d-m-Y", $event_date); } ?>" class="datepicker" />
	<?php 
		
		// if (!empty($event_date)) { echo '(This is a ' . date("l", $event_date) . ')'; }
	?>
	</p>
	<p>
	<label for="event_location" style="width:100px;">Event location</label>
	<input type="text" name="event_location" id="event_location" style="width:500px;" value="<?php echo $event_location; ?>" />
	</p>
	<p>
	<label for="event_time" style="width:100px;">Event time</label>
	<input type="text" name="event_time" id="event_time" style="width:500px;" value="<?php echo $event_time; ?>" />
	</p>
	<?php	
}
add_action( 'save_post', 'event_details_meta_box_save' );
function event_details_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);
	
	// Make sure your data is set before trying to save it
	if( isset( $_POST['event_date'] ) )
			$converteddate = strtotime($_POST['event_date']);
		update_post_meta( $post_id, 'event_date', $converteddate );
		
	if( isset( $_POST['event_location'] ) )
		update_post_meta( $post_id, 'event_location', wp_kses( $_POST['event_location'], $allowed ) );
	
	if( isset( $_POST['event_time'] ) )
		update_post_meta( $post_id, 'event_time', wp_kses( $_POST['event_time'], $allowed ) );

}

// 2. Link to page
	//http://wp.tutsplus.com/tutorials/plugins/how-to-create-custom-wordpress-writemeta-boxes/

	function cd_meta_box_cb( $post )
	{
		$url = get_post_meta($post->ID, 'url', true);
		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); ?>

		<p>
			<label for="url">Page link</label>
			<input type="text" name="url" id="url" value="<?php echo $url; ?>" style="width:350px" />
		</p>

		<?php	
	}
	
	add_action( 'save_post', 'cd_meta_box_save' );
	function cd_meta_box_save( $post_id )
	{
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;

		// now we can actually save the data
		$allowed = array( 
			'a' => array( // on allow a tags
				'href' => array() // and those anchors can only have href attribute
			)
		);

		// Probably a good idea to make sure your data is set
		if( isset( $_POST['url'] ) )
			update_post_meta( $post_id, 'url', wp_kses( $_POST['url'], $allowed ) );
	}
	

// 3. List of pages

	function list_of_pages_meta( $post )
	{
		$values = get_post_custom( $post->ID );
		$list_of_pages = isset( $values['list_of_pages'] ) ? esc_attr( $values['list_of_pages'][0] ) : '';
		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
		?>

		<p>
		<select name="list_of_pages" id="list_of_pages">
			<option value="">None</option>
			<option value="All pages"<?php if ($list_of_pages == 'All pages') : echo 'selected'; endif;  ?>>All pages</option>
			<?php 
			$args = array('hierarchical' => true);
			$pages=get_pages($args); 
			foreach ($pages as $page) { ?>
				<option value="<?php echo $page->post_title; ?>" <?php if ($page->post_title == $list_of_pages) : echo 'selected'; endif;  ?>><?php echo $page->post_title; ?></option>
			<?php } ?> 
		</select>
		This ad will display on<?php echo $list_of_pages ?>
		</p>
		<p>
		<h4 style="margin-bottom:5px;">Help:</h4>
		Selection options:
		<ul style="margin-left:15px; margin-top:5px;">
			<li><b>None</b>. Ad will not display anywhere on the site.</li>
			<li><b>All pages</b>. Ad will display on all pages of the site.</li>
			<li><b>Page</b> <em>(e.g. 'Home page' or 'Dispensing and Supply')</em>. Ad will display on the selected page only (this will over-ride any other ad that is selected for 'All pages'.</li>
		</ul>
		</p>

		<?php	
	}
	
	function list_of_pages_meta_box_save( $post_id )
	{
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
		
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		// now we can actually save the data
		$allowed = array( 'a' => array('href' => array()), 'ul' => array(), 'li' => array(), 'p' => array(), 'ol' => array());
		
		// Make sure your data is set before trying to save it
		if( isset( $_POST['list_of_pages'] ) )
			update_post_meta( $post_id, 'list_of_pages', $_POST['list_of_pages'] );
	}
	add_action( 'save_post', 'list_of_pages_meta_box_save' );
	
// 4. Exclude from search
function exclude_from_search_meta($post) {
	$values = get_post_custom( $post->ID );
	$exclude_from_search = isset( $values['exclude_from_search'] ) ? esc_attr( $values['exclude_from_search'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>
	<label for="exclude_from_search" style="width:100px;">Select whether this page should be excluded from site search results.</label>
	</p>
	<p>
	<select name="exclude_from_search" id="exclude_from_search">
		<option name="no" value="no" <?php if ($exclude_from_search == 'no') : echo 'selected'; endif ; ?>>No</option>
		<option name="yes" value="yes" <?php if ($exclude_from_search == 'yes') : echo 'selected'; endif ; ?>>Yes</option>
	</select>
	</p>
	<?php	
}
add_action( 'save_post', 'exclude_from_search_meta_save' );
function exclude_from_search_meta_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);
	
	// Make sure your data is set before trying to save it
	if( isset( $_POST['exclude_from_search'] ) )
		update_post_meta( $post_id, 'exclude_from_search', wp_kses( $_POST['exclude_from_search'], $allowed ) );

}

// 5. Content expiry
function content_expiration_meta($post) {
	$values = get_post_custom( $post->ID );
	$expiration_day = isset( $values['expiration_day'] ) ? esc_attr( $values['expiration_day'][0] ) : '';
	$expiration_month = isset( $values['expiration_month'] ) ? esc_attr( $values['expiration_month'][0] ) : '';
	$expiration_year = isset( $values['expiration_year'] ) ? esc_attr( $values['expiration_year'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<!--<p>
	<input type="text" name="content_expiration" id="content_expiration" value="<?php echo $content_expiration ?>" class="content_expiration" />
	</p>-->
	<p>
	Select the date this content will expire.
	</p>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>DD</td>
			<td>MM</td>
			<td>YYYY</td>
		</tr>
		<tr>
			<td>
				<input type="text" name="expiration_day" id="expiration_day" value="<?php echo $expiration_day ?>" size="2" placeholder="dd" />
			</td>
			<td>
				<select name="expiration_month" id="expiration_month">
					<option value="">Select month</option>
					<option value="01" <?php if ($expiration_month == 01) : echo 'selected'; endif; ?>>01-Jan</option>
					<option value="02" <?php if ($expiration_month == 02) : echo 'selected'; endif; ?>>02-Feb</option>
					<option value="03" <?php if ($expiration_month == 03) : echo 'selected'; endif; ?>>03-Mar</option>
					<option value="04" <?php if ($expiration_month == 04) : echo 'selected'; endif; ?>>04-Apr</option>
					<option value="05" <?php if ($expiration_month == 05) : echo 'selected'; endif; ?>>05-May</option>
					<option value="06" <?php if ($expiration_month == 06) : echo 'selected'; endif; ?>>06-Jun</option>
					<option value="07" <?php if ($expiration_month == 07) : echo 'selected'; endif; ?>>07-Jul</option>
					<option value="08" <?php if ($expiration_month == '08') : echo 'selected'; endif; ?>>08-Aug</option>
					<option value="09" <?php if ($expiration_month == '09') : echo 'selected'; endif; ?>>09-Sep</option>
					<option value="10" <?php if ($expiration_month == 10) : echo 'selected'; endif; ?>>10-Oct</option>
					<option value="11" <?php if ($expiration_month == 11) : echo 'selected'; endif; ?>>11-Nov</option>
					<option value="12" <?php if ($expiration_month == 12) : echo 'selected'; endif; ?>>12-Dec</option>
				</select>
			</td>
			<td>
				<input type="text" name="expiration_year" id="expiration_year" value="<?php echo $expiration_year ?>" size="4"  placeholder="yyyy" />
			</td>
		</tr>
	</table>
	<?php
}

function content_expiration_meta_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);
	
	// Make sure your data is set before trying to save it
	if( isset( $_POST['expiration_day'] ) )
		update_post_meta( $post_id, 'expiration_day', wp_kses( $_POST['expiration_day'], $allowed ) );
	if( isset( $_POST['expiration_month'] ) )
		update_post_meta( $post_id, 'expiration_month', wp_kses( $_POST['expiration_month'], $allowed ) );
	if( isset( $_POST['expiration_year'] ) )
		update_post_meta( $post_id, 'expiration_year', wp_kses( $_POST['expiration_year'], $allowed ) );
}
add_action( 'save_post', 'content_expiration_meta_save' );

// 6. SEO Description
function seo_description_meta($post) {
	$values = get_post_custom( $post->ID );
	$seo_description = isset( $values['seo_description'] ) ? esc_attr( $values['seo_description'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); 
	?>
	<p>Enter a description for this page to appear in Search Engine results.<br><img src="/wp-content/themes/psnc/img/meta-description.jpg" alt=""></p>
	<p>
	<textarea id="seo_description" name="seo_description" style="width:100%; height:100px;"><?php echo $seo_description; ?></textarea>
	</p>
	<?php	
}
add_action( 'save_post', 'seo_description_meta_save' );
function seo_description_meta_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);
	
	// Make sure your data is set before trying to save it
	if( isset( $_POST['seo_description'] ) )
		update_post_meta( $post_id, 'seo_description', wp_kses( $_POST['seo_description'], $allowed ) );

}


// END custom meta boxes

	add_filter("manage_feature_edit_columns", "feature_edit_columns");

	function feature_edit_columns($feature_columns){
	   $feature_columns = array(
	      "cb" => "<input type=\"checkbox\" />",
	      "title" => "Title",
	   );
	  return $feature_columns;
	}
	
	// Show order on Manage Posts
	function add_new_feature_column($feature_columns) {
	  $feature_columns['menu_order'] = "Order";
	  return $feature_columns;
	}
	add_action('manage_edit-feature_columns', 'add_new_feature_column');
	function show_order_column($name){
	  global $post;
	
	  switch ($name) {
	    case 'menu_order':
	      $order = $post->menu_order;
	      echo $order;
	      break;
	   default:
	      break;
	   }
	}
	add_action('manage_feature_posts_custom_column','show_order_column');
	/**
	* make column sortable
	*/
	function order_column_register_sortable($columns){
	  $columns['menu_order'] = 'menu_order';
	  return $columns;
	}
	add_filter('manage_edit-feature_sortable_columns','order_column_register_sortable');


/*------------------------------------*\
	Configure mail to use SMTP
\*------------------------------------*/


function custom_phpmailer_init($PHPMailer)
{
	$PHPMailer->IsSMTP();
	$PHPMailer->SMTPAuth = true;
	$PHPMailer->SMTPSecure = 'tls';
	$PHPMailer->Host = 'smtp.mandrillapp.com';
	$PHPMailer->Port = 587;
	$PHPMailer->Username = 'reachus@jellyhaus.com';
	$PHPMailer->Password = 'euXo2wMZpHMqk_w1FoA9xw';
}
add_action('phpmailer_init', 'custom_phpmailer_init');

/** changing default wordpres email settings */
 
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');
 
function new_mail_from($old) {
 return 'website@psnc.org.uk';
}
function new_mail_from_name($old) {
 return 'PSNC';
}


/*------------------------------------*\
	Customise admin
\*------------------------------------*/

// TinyMCE Editor
/*
if ( ! function_exists('tdav_css') ) {
	function tdav_css($wp) {
		$wp .= ',' . get_bloginfo('stylesheet_url');
	return $wp;
	}
}
add_filter( 'mce_css', 'tdav_css' );
*/


// menu order
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	
	return array(
		'index.php', // Dashboard
		'separator1', // First separator
		'edit.php', // Posts
		'edit.php?post_type=page', // Pages
		'edit.php?post_type=our-latest-news', // Latest News
		'edit.php?post_type=our-services', // Services
		'edit.php?post_type=our-publications', // Publications
		'edit.php?post_type=our-events', // Events
		'upload.php', // Media
		'link-manager.php', // Links
		'edit-comments.php', // Comments
		'separator2', // Second separator
		'themes.php', // Appearance
		'edit.php?post_type=menu-feature', // Menu Feature
		'edit.php?post_type=feature', // Home page slider
		'edit.php?post_type=psnc-ads', // Banner ads
		'plugins.php', // Plugins
		'users.php', // Users
		'tools.php', // Tools
		'options-general.php', // Settings
		'separator-last', // Last separator
	);
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

// remove menu items
function edit_admin_menus() {
	
	remove_menu_page('edit.php');
	remove_menu_page('link-manager.php');
	remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'edit_admin_menus' );

function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('new-post', 'new-content');
    
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


// custom menu styling
?>
<?php
add_action( 'admin_head', 'cpt_icons' );
function cpt_icons() {
    ?>
    <style type="text/css" media="screen">
    /* icons */
    #menu-posts-latest-news .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/images/YOURIMAGE.png) no-repeat 6px -17px !important;}
	#menu-posts-latest-news:hover .wp-menu-image, #menu-posts-latest-news.wp-has-current-submenu .wp-menu-image {background-position:6px 7px!important;}
	
	#menu-posts-services .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/images/YOURIMAGE.png) no-repeat 6px -17px !important;}
	#menu-posts-services:hover .wp-menu-image, #menu-posts-services.wp-has-current-submenu .wp-menu-image {background-position:6px 7px!important;}
	
	#menu-posts-publications .wp-menu-image {background: url(<?php bloginfo('template_url') ?>/images/YOURIMAGE.png) no-repeat 6px -17px !important;}
	#menu-posts-publications:hover .wp-menu-image, #menu-posts-publications.wp-has-current-submenu .wp-menu-image {background-position:6px 7px!important;}
	
	
	#adminmenuback, #adminmenuwrap {background-color: #f3ecf4;}
	#wpadminbar {background:#503388 ; /* DEV background: red;*/}
	a, #adminmenu a, #the-comment-list p.comment-author strong a, #media-upload a.del-link, #media-items a.delete, #media-items a.delete-permanently, .plugins a.delete, .ui-tabs-nav a {color: #503388;}
	#wpadminbar * {color: #fff;}
	#adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li.menu-top:focus {color:#c3147b;}
	#wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a {color: #503388;}
	#wpadminbar .quicklinks li div.blavatar {background: none !important;}
	#logo a {background: none !important;}
	.scottsweb-credit {display:none;}
	#toplevel_page_ckeditor_settings { display: none; }
	.toplevel_page_awqsf { display: none; }
	option[value="esa_plugin_manager"]{display: none;}
	
    </style>
<?php } ?>
<?php 
// hide redundant roles
function my_custom_admin_head(){
echo '<script>jQuery(document).ready(function() { jQuery("option[value=\'esa_plugin_manager\']").remove(); jQuery("option[value=\'basic_contributor\']").remove();'; 
	if ( is_super_admin() ) { 
	echo 'jQuery("#tadvadmin").remove()';	
	}
echo '});</script>';
}
add_action('admin_head', 'my_custom_admin_head');
?>
<?php

// admin bar
function annointed_admin_bar_remove() {
        global $wp_admin_bar;

        /* Remove their stuff */
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('comments');
}

add_filter( 'contextual_help', 'mycontext_remove_help', 999, 3 );
  function mycontext_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}

add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {

/* Add the "My Account" menu */

$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}

// footer

function remove_footer_admin () {
  echo '<img src="'; bloginfo('template_url'); echo '/img/jellyhaus-admin.png" alt="Jellyhaus"> Built by <a href="http://www.jellyhaus.com" target="_blank">Jellyhaus</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// login

function custom_login_logo() {
echo '<style type="text/css">
h1 a { background-image:url('.get_bloginfo('template_directory').'/img/psnc-login.png) !important; background-size:auto !important; #logo a {background-image:none !important;}
</style>';
}
add_action('login_head', 'custom_login_logo');

function loginpage_custom_link() {
	return '/';
}
add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
	return 'Return to site';
}
add_filter('login_headertitle', 'change_title_on_logo');

function no_errors_please(){
  return '';
}
add_filter( 'login_errors', 'no_errors_please' );


// hide update for non admins

if ( !current_user_can('administrator') ) {
add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// custom editor styles

$your_custom_stylesheet = 'css/custom-editor-style.css';
add_editor_style($your_custom_stylesheet);

// Dashboard widgets

function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

add_action('wp_network_dashboard_setup', 'hhs_remove_network_dashboard_widgets' );
function hhs_remove_network_dashboard_widgets() {
    remove_meta_box ( 'network_dashboard_right_now', 'dashboard-network', 'normal' ); // Right Now
    remove_meta_box ( 'dashboard_plugins', 'dashboard-network', 'normal' ); // Plugins
    remove_meta_box ( 'dashboard_primary', 'dashboard-network', 'side' ); // WordPress Blog
    remove_meta_box ( 'dashboard_secondary', 'dashboard-network', 'side' ); // Other WordPress News
}

// Single site Dashboard
/*function welcome_dashboard_widget() { 
echo '<p>For any technical enquiries, please email <a href="mailto:info@psnc.org.uk">info@psnc.org.uk</a></p><div style="padding:10px; background:white; border: 1px solid #d58721"><h2>Website Setup Guides</h2><p style="font-size:1.3em;">Please <a href="/wp-content/uploads/manuals/lpc-website-user-manual.pdf" target="_blank">click here</a> to view the user guide.</p><p style="font-size:1.3em;">Please <a href="/wp-content/uploads/manuals/LPCtasklist.pdf" target="_blank">click here</a> to download the site set up task list.</p></div>';
};
function add_your_dashboard_widget() {
  wp_add_dashboard_widget( 'welcome_dashboard_widget', __( 'Welcome to the PSNC Network' ), 'welcome_dashboard_widget' );
}
add_action('wp_dashboard_setup', 'add_your_dashboard_widget' );*/

// Google Groups Dashboard widget
function forum_dashboard_widget() { 
	echo '<iframe id="forum_embed"  src="https://groups.google.com/forum/embed/?place=forum/psnc"  scrolling="no"  frameborder="0"  width="100%"  height="700"></iframe>';
};
function add_forum_dashboard_widget() {
	add_meta_box( 'forum_dashboard_widget', 'PSNC Network Google Groups Forum', 'forum_dashboard_widget', 'dashboard', 'side', 'high' );
}
global $blog_id;
if ( current_user_can_for_blog ( $blog_id, "administrator" ) ) :
	add_action('wp_dashboard_setup', 'add_forum_dashboard_widget' );
endif;

// PSNC Dashboard widget
function psnc_dashboard_widget() { 
	global $switched;
    switch_to_blog(92);
	echo get_post_field('post_content', 139);
	restore_current_blog();
};
function add_psnc_dashboard_widget() {
	wp_add_dashboard_widget( 'psnc_dashboard_widget', __( 'PSNC Messages' ), 'psnc_dashboard_widget' );
}
global $blog_id;
if ( current_user_can_for_blog ( $blog_id, "administrator" ) ) :
	add_action('wp_dashboard_setup', 'add_psnc_dashboard_widget' );
endif;

// Network Dashboard
function welcome_networkdashboard_widget() { 
echo '<p>For any technical enquiries, please email <a href="mailto:website@psnc.org.uk">website@psnc.org.uk</a></p><div style="padding:10px; background:white; border: 1px solid #d58721"><h2>Website Setup Guides</h2><p style="font-size:1.3em;">Please <a href="/wp-content/uploads/manuals/lpc-website-user-manual.pdf" target="_blank">click here</a> to view the user guide.</p><p style="font-size:1.3em;">Please <a href="/wp-content/uploads/manuals/LPCtasklist.pdf" target="_blank">click here</a> to download the site set up task list.</p></div>';
};
function add_networkdashboard_widget() {
  wp_add_dashboard_widget( 'welcome_networkdashboard_widget', __( 'Welcome to the PSNC LPC Network Admin' ), 'welcome_networkdashboard_widget' );
}
add_action('wp_network_dashboard_setup', 'add_networkdashboard_widget' );


// get top level page ID
function get_top_parent_page_id() {

    global $post;

    // Check if page is a child page (any level)
    if ($post->ancestors) {

        //  Grab the ID of top-level page from the tree
        return end( get_post_ancestors($post) );

    } else {

        // Page is the top level, so use  it's own id
        return $post->ID;

    }

}

/*------------------------------------*\
	User functions
\*------------------------------------*/




/*------------------------------------*\
	Boilerplate functions
\*------------------------------------*/


// Protocol relative URLs for enqueued scripts/styles
function html5blank_protocol_relative($url)
{
	if(is_admin()) return $url;
	return str_replace(array('http:','https:'), '', $url, $c=1);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if (!is_admin()) {
    
    	// wp_deregister_script('jquery'); // Deregister WordPress jQuery
    	// wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array(), '1.9.1'); // Google CDN jQuery
    	// wp_enqueue_script('jquery'); // Enqueue it!
    	
    	wp_register_script('conditionizr', 'http://cdnjs.cloudflare.com/ajax/libs/conditionizr.js/2.2.0/conditionizr.min.js', array(), '2.2.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!
        
        wp_register_script('modernizr', 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '2.6.2'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!
        
        wp_register_script('bxSlider', get_template_directory_uri() . '/js/jquery.bxSlider.js', array(), '1.0.0'); // BxSlider
        wp_enqueue_script('bxSlider'); // Enqueue it!
        
        wp_register_script('respond', get_template_directory_uri() . '/js/respond.min.js', array(), '1.0.0'); // Responsive to the masses
        wp_enqueue_script('respond'); // Enqueue it!
        
        // wp_register_script('jqcycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', array(), '1.0.0'); // jQuery cycle
        // wp_enqueue_script('jqcycle'); // Enqueue it!
        
        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
        
        
    }
    
    if(is_admin()){
        wp_enqueue_script('jquery-ui-datepicker');
    }
}

// Load HTML5 Blank conditional scripts
function conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!
    
    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    //$GLOBALS['wp_styles']->add_data( 'html5blank', 'conditional', '!lte IE 6' );
    wp_enqueue_style('html5blank'); // Enqueue it!
    
    wp_register_style('bxslider', get_template_directory_uri() . '/css/jquery.bxslider.css', array(), '1.0', 'all');
    wp_enqueue_style('bxslider'); // Enqueue it!
}


// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts

function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// hook into the default excerpt

function custom_wp_trim_excerpt($text) {
$raw_excerpt = $text;
if ( '' == $text ) {
    //Retrieve the post content. 
    $text = get_the_content('');
 
    //Delete all shortcode tags from the content. 
    $text = strip_shortcodes( $text );
 
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
     
    $allowed_tags = ''; /*** <a>, <b>, <strong> MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
    $text = strip_tags($text, $allowed_tags);
     
    $excerpt_word_count = 55; /*** MODIFY THIS. change the excerpt word count to any integer you like.***/
    $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
     
    $excerpt_end = '[...]'; /*** MODIFY THIS. change the excerpt endind to something else.***/
    $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
     
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }
}
return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');



// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '...<a class="view-article" href="' . get_permalink($post->ID) . '">' . '' . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}


/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('script_loader_src', 'html5blank_protocol_relative'); // Protocol relative URLs for enqueued scripts
add_filter('style_loader_src' , 'html5blank_protocol_relative'); // Protocol relative URLs for enqueued styles
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
// remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// fix to make iframes work
/*function myformatTinyMCE($in)
{
 $in['remove_linebreaks']=false;
 $in['gecko_spellcheck']=false;
 $in['keep_styles']=true;
 $in['accessibility_focus']=true;
 $in['tabfocus_elements']='major-publishing-actions';
 $in['media_strict']=false;
 $in['paste_remove_styles']=false;
 $in['paste_remove_spans']=false;
 $in['paste_strip_class_attributes']='none';
 $in['paste_text_use_dialog']=true;
 $in['wpeditimage_disable_captions']=true;
 $in['plugins']='inlinepopups,tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
 $in['content_css']=get_template_directory_uri() . "/editor-style.css";
 $in['wpautop']=true;
 $in['apply_source_formatting']=false;
 $in['theme_advanced_buttons1']='formatselect,forecolor,|,bold,italic,underline,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,wp_fullscreen,wp_adv';
 $in['theme_advanced_buttons2']='pastetext,pasteword,removeformat,|,charmap,|,outdent,indent,|,undo,redo';
 $in['theme_advanced_buttons3']='charmap';
 $in['theme_advanced_buttons4']='';
 $in['content_css']=get_template_directory_uri() . "/css/wpeditor.css";
 return $in;
}
add_filter('tiny_mce_before_init', 'myformatTinyMCE' );*/

/*function my_theme_add_editor_styles() {
    add_editor_style( 'css/wpeditor.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );*/
?>
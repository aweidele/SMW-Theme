<?php
/*** SCRIPTS AND STYLES ***/
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
function theme_scripts() {
  if(is_page_template('template-anniversary.php') || is_page_template('template-tou.php')) {
    wp_enqueue_style('anniversary-style',get_stylesheet_directory_uri().'/anniversary.css',array(),(rand(0,100)/10));
    wp_enqueue_script('anniversary-script',get_stylesheet_directory_uri() . '/inc/anniversary.js',array( 'jquery' ),'1.0',true);
  } else {
    wp_enqueue_style('main',get_stylesheet_uri(),array());
    wp_enqueue_script('jquery-mobile',get_stylesheet_directory_uri() . '/inc/jquery.mobile.custom.min.js',array( 'jquery' ),'1.0',true);
    wp_enqueue_script('main-script',get_stylesheet_directory_uri() . '/inc/script.js',array( 'jquery' ),strval(filemtime(get_template_directory()."/inc/script.js")),true);
    
	wp_enqueue_style("adamcss", get_template_directory_uri()."/adam.css", array(), strval(filemtime(get_template_directory()."/adam.css")) );
	wp_enqueue_style("overridescss", get_template_directory_uri()."/overrides.css", array(), strval(filemtime(get_template_directory()."/overrides.css")) );
    wp_enqueue_script('imagesLoaded',get_stylesheet_directory_uri() . '/inc/imagesLoaded.pkgd.min.js',array( 'jquery' ),'1.0');
    wp_enqueue_script('packery',get_stylesheet_directory_uri() . '/inc/packery.pkgd.min.js',array( 'jquery' ),'1.0');
  }
  
  if(is_page_template('template-projects.php')) {
    wp_enqueue_script('jquery-cookie',get_stylesheet_directory_uri() . '/inc/jquery.cookie.min.js',array( 'jquery' ),'1.0',true);
  	wp_enqueue_script('jquery-sortTable',get_stylesheet_directory_uri() . '/inc/jquery.sortTable.js',array( 'jquery' ),'1.0',true);
  }
  
  if(is_page_template('template-careers.php')) {
    wp_enqueue_script('jquery-cookie',get_stylesheet_directory_uri() . '/inc/jobnav.js',array( 'jquery' ),'1.0',true);
  }
  
  // Block mapplic from starting, we'll do it ourselves.
  wp_enqueue_script('mapplic-instance', get_stylesheet_directory_uri() . '/inc/empty.js', array('mapplic-script'), null, true);
	
}

/*** UPSCALE IMAGES ***/


/*** IMAGE SIZES ***/
add_theme_support('post-thumbnails');
add_image_size('Anniversary Slideshow',790,620,true);
add_image_size('Anniversary Slideshow Thumb',109,85,true);
add_image_size('Large Slideshow',825,550,true);
add_image_size('Project Quote Photo',255,340,true);
add_image_size('Homepage Slideshow Thumb',350,260,true);
add_image_size('Grid Slideshow Small',270,190,true);
add_image_size('Grid Slideshow Large',570,410,true);
add_image_size('Leadership Thumb',120,120,true);
add_image_size('Services Background',877,999999);
add_image_size('Banner',1170,464,true);
add_image_size('Mobile Background',2048,999999,true);


/*** ADD SUPPORT FOR CUSTOM MENUS ***/
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
  register_nav_menu( 'footer-menu', __( 'Footer Nav' ) );
  register_nav_menu( 'top-menu', __( 'Top Nav' ) );
  register_nav_menu( 'top-menu-mobile', __( 'Top Nav Mobile' ) );
}

require_once('inc/smw_nav.php');

/*** THEME CUSTOMIZATION SETTINGS ***/
function mytheme_customize_register( $wp_customize ) {

  // ANNIVERSARY SITE INFO
  $wp_customize->add_section( 'smw_anniv' , array(
    'title'      => __( 'Anniversary Info', 'mytheme' ),
    'priority'   => 30,) 
  );

  // Add Settings
  $wp_customize->add_setting( 'smw_anniv_tagline'    , array('transport' => 'refresh','type' => 'option'));
  
  // Add Controls
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_anniv_tagline', array(
	'label'        => __( 'Tagline', 'mytheme' ),
	'section'    => 'smw_anniv',
	'settings'   => 'smw_anniv_tagline',
  ) ) );
  
  // CONTACT INFO
  $wp_customize->add_section( 'smw_contact' , array(
    'title'      => __( 'Contact Info', 'mytheme' ),
    'priority'   => 30,) 
  );

  // Add Settings
  $wp_customize->add_setting( 'smw_email'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_copyright'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_fb'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_fbtext'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_tw'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_twtext'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_in'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_intext'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_li'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_litext'    , array('transport' => 'refresh','type' => 'option'));
  
  
  // Add Controls
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_email', array(
	'label'        => __( 'Email', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_email',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_copyright', array(
	'label'        => __( 'Copyright info', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_copyright',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_fb', array(
	'label'        => __( 'Facebook (URL)', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_fb',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_fbtext', array(
	'label'        => __( 'Facebook Text', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_fbtext',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_tw', array(
	'label'        => __( 'Twitter (URL)', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_tw',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_twtext', array(
	'label'        => __( 'Twitter Text', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_twtext',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_in', array(
	'label'        => __( 'Instagram (URL)', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_in',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_intext', array(
	'label'        => __( 'Instagram Text', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_intext',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_li', array(
	'label'        => __( 'LinkedIn (URL)', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_li',
  ) ) );
  
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'smw_litext', array(
	'label'        => __( 'LinkedIn Text', 'mytheme' ),
	'section'    => 'smw_contact',
	'settings'   => 'smw_litext',
  ) ) );
  
  
  // SITE IDENTITY
  
  // Add Settings
  $wp_customize->add_setting( 'smw_logo'    , array('transport' => 'refresh','type' => 'option'));
  $wp_customize->add_setting( 'smw_anniversary_logo'    , array('transport' => 'refresh','type' => 'option'));
  
  // Add Controls
  $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'smw_logo', array(
	'label'      => __( 'Logo', 'mytheme' ),
	'section'    => 'title_tagline',
	'settings'   => 'smw_logo',
  ) ) );
  $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'smw_anniversary_logo', array(
	'label'      => __( 'Anniversary Logo', 'mytheme' ),
	'section'    => 'title_tagline',
	'settings'   => 'smw_anniversary_logo',
  ) ) );
  
  
}
add_action( 'customize_register', 'mytheme_customize_register' );

/*** ALLOW SVG IN MEDIA LIBRARY ***/
function smw_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'smw_mime_types');

/*** POST TYPES ***/
add_action('init', 'register_post_types');
function register_post_types() {

    
    /**** REGISTER PROJECTS POST TYPE ****/
	$labels = array(
		'name' => _x('Projects', 'post type general name'),
		'singular_name' => _x('Project', 'post type singular name'),
		'add_new' => _x('Add New Project', 'portfolio item'),
		'add_new_item' => __('Add New Project'),
		'edit_item' => __('Edit Project'),
		'new_item' => __('New Project'),
		'view_item' => __('View Project'),
		'search_items' => __('Search Projects'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','tags')
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'projects' , $args );
	
	// Project Tags Taxonomy
    register_taxonomy(
        'project_tags',
        'projects',
        array(
            'labels' => array(
                'name'              => _x( 'Project Tags' , 'taxonomy general name' ),
                'singular_name'     => _x( 'Project Tag' , 'taxonomy singular name'),
                'add_new_item' => 'Add Project Tag',
                'new_item_name' => "New Project Tag"
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'hierarchical' => false,
            'support' => array('tags')
        )
    );

    
    /**** REGISTER SERVICES POST TYPE ****/
	$labels = array(
		'name' => _x('Services', 'post type general name'),
		'singular_name' => _x('Service', 'post type singular name'),
		'add_new' => _x('Add New Service', 'portfolio item'),
		'add_new_item' => __('Add New Service'),
		'edit_item' => __('Edit Service'),
		'new_item' => __('New Service'),
		'view_item' => __('View Service'),
		'search_items' => __('Search Services'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt'),
		'show_in_menu' => 'edit.php?post_type=projects',
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'services' , $args );

    
    /**** REGISTER EXPERTISE POST TYPE ****/
	$labels = array(
		'name' => _x('Markets', 'post type general name'),
		'singular_name' => _x('Market', 'post type singular name'),
		'add_new' => _x('Add New Market', 'portfolio item'),
		'add_new_item' => __('Add New Market'),
		'edit_item' => __('Edit Market'),
		'new_item' => __('New Market'),
		'view_item' => __('View Market'),
		'search_items' => __('Search Markets'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'market'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt'),
		'show_in_menu' => 'edit.php?post_type=projects',
		//"menu_position" => 21
	  ); 
	register_post_type( 'industry' , $args );

    
    /**** REGISTER REGION POST TYPE ****/
// 	$labels = array(
// 		'name' => _x('Regions', 'post type general name'),
// 		'singular_name' => _x('Region', 'post type singular name'),
// 		'add_new' => _x('Add New Region', 'portfolio item'),
// 		'add_new_item' => __('Add New Region'),
// 		'edit_item' => __('Edit Region'),
// 		'new_item' => __('New Region'),
// 		'view_item' => __('View Region'),
// 		'search_items' => __('Search Region'),
// 		'not_found' =>  __('Nothing found'),
// 		'not_found_in_trash' => __('Nothing found in Trash'),
// 		'parent_item_colon' => ''
// 	);
//  
// 	$args = array(
// 		'labels' => $labels,
// 		'public' => true,
// 		'publicly_queryable' => true,
// 		'show_ui' => true,
// 		'query_var' => true,
// 		'menu_icon' => get_stylesheet_directory_uri() . '/image/nav_team.png',
// 		'rewrite' => true,
// 		'capability_type' => 'post',
// 		'hierarchical' => false,
// 		'menu_position' => null,
// 		'supports' => array('title'),
// 		'show_in_menu' => 'edit.php?post_type=projects',
// 		//"menu_position" => 21
// 	  ); 
// 	register_post_type( 'region' , $args );

	
    
    /**** REGISTER OUR PEOPLE POST TYPE ****/
	$labels = array(
		'name' => _x('Bios', 'post type general name'),
		'singular_name' => _x('Bio', 'post type singular name'),
		'add_new' => _x('Add New Bio', 'portfolio item'),
		'add_new_item' => __('Add New Bio'),
		'edit_item' => __('Edit Bio'),
		'new_item' => __('New Bio'),
		'view_item' => __('View Bio'),
		'search_items' => __('Search Bios'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt'),
		'taxonomies'          => array( 'category' ),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'ourpeople' , $args );
    
    
    /**** REGISTER LEADERSHIP POST TYPE 
	$labels = array(
		'name' => _x('Leadership', 'post type general name'),
		'singular_name' => _x('Leadership', 'post type singular name'),
		'add_new' => _x('Add New Leadership', 'portfolio item'),
		'add_new_item' => __('Add New Leadership'),
		'edit_item' => __('Edit Leadership'),
		'new_item' => __('New Leadership'),
		'view_item' => __('View Leadership'),
		'search_items' => __('Search Leadership'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'leadership' , $args ); **/

    
    /**** REGISTER LOCATIONS POST TYPE ****/
	$labels = array(
		'name' => _x('Locations', 'post type general name'),
		'singular_name' => _x('Location', 'post type singular name'),
		'add_new' => _x('Add New Location', 'Location item'),
		'add_new_item' => __('Add New Location'),
		'edit_item' => __('Edit Location'),
		'new_item' => __('New Location'),
		'view_item' => __('View Location'),
		'search_items' => __('Search Locations'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'location' , $args );
    
    /**** TIMELINE ITEMS POST TYPE ****/
	$labels = array(
		'name' => _x('Timeline Items', 'post type general name'),
		'singular_name' => _x('Timeline Item', 'post type singular name'),
		'add_new' => _x('Add New Timeline Item', 'portfolio item'),
		'add_new_item' => __('Add New Timeline Item'),
		'edit_item' => __('Edit Timeline Item'),
		'new_item' => __('New Timeline Item'),
		'view_item' => __('View Timeline Item'),
		'search_items' => __('Search Timeline Items'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'timeline_items' , $args );
    
    /**** NEWSLETTER POST TYPE ****/
	$labels = array(
		'name' => _x('Newsletters', 'post type general name'),
		'singular_name' => _x('Newsletter', 'post type singular name'),
		'add_new' => _x('Add New Newsletter', 'portfolio item'),
		'add_new_item' => __('Add New Newsletter'),
		'edit_item' => __('Edit Newsletter'),
		'new_item' => __('New Newsletter'),
		'view_item' => __('View Newsletter'),
		'search_items' => __('Search Newsletters'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'newsletter' , $args );
    
    /**** JOBS POST TYPE ****/
	$labels = array(
		'name' => _x('Job Listings', 'post type general name'),
		'singular_name' => _x('Job Listing', 'post type singular name'),
		'add_new' => _x('Add New Job Listing', 'portfolio item'),
		'add_new_item' => __('Add New Job Listing'),
		'edit_item' => __('Edit Job Listing'),
		'new_item' => __('New Job Listing'),
		'view_item' => __('View Job Listing'),
		'search_items' => __('Search Job Listings'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'jobs' , $args );
    
    /**** NEWSLETTER POST TYPE ****/
	$labels = array(
		'name' => _x('Newsletters', 'post type general name'),
		'singular_name' => _x('Newsletter', 'post type singular name'),
		'add_new' => _x('Add New Newsletter', 'portfolio item'),
		'add_new_item' => __('Add New Newsletter'),
		'edit_item' => __('Edit Newsletter'),
		'new_item' => __('New Newsletter'),
		'view_item' => __('View Newsletter'),
		'search_items' => __('Search Newsletters'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
	//	'menu_icon' => get_stylesheet_directory_uri() . '/image/nav_team.png',
        'menu_icon'   => 'dashicons-shooby-doo',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor'),
		//"menu_position" => 21
	  ); 
 
	register_post_type( 'newsletter' , $args );
    flush_rewrite_rules();
}

add_filter( 'manage_projects_posts_columns', 'set_custom_edit_projects_columns' );
add_action( 'manage_projects_posts_custom_column' , 'custom_projects_column', 10, 2 );
function set_custom_edit_projects_columns($columns) {
    $columns['project_services'] = __( 'Services', 'your_text_domain' );
    $columns['project_industry'] = __( 'Industry', 'your_text_domain' );
    $columns['project_region'] = __( 'Location', 'your_text_domain' );

    return $columns;
}

function custom_projects_column( $column, $post_id ) {
    switch ( $column ) {

        case 'project_region' :
            $region = get_post_meta( $post_id , 'region' , true );
            if(is_array($region) && sizeof($region)) {
              foreach($region as $i => $r) {
                if($i > 0) { echo ', '; }
                echo get_the_title($r);
              }
            }
            break;

        case 'project_industry' :
            $industry = get_post_meta( $post_id , 'industry' , true );
            if(is_array($industry) && sizeof($industry)) {
              foreach($industry as $i => $ind) {
                if($i > 0) { echo ', '; }
                echo get_the_title($ind);
              }
            }
            break;

        case 'project_services' :
            $services = get_post_meta( $post_id , 'services' , true );
            if(is_array($services) && sizeof($services)) {
              foreach($services as $i => $s) {
                if($i > 0) { echo ', '; }
                echo get_the_title($s);
              }
            }
            break;

    }
}


function project_thumb($projectID,$size) {
  $thumb = get_the_post_thumbnail($projectID,$size);
  if($thumb == "") {
    $g = get_field('photos',$projectID);
    if(sizeof($g)) {
      $thumb = '<img src="'.$g[0]['sizes'][$size].'">';
    }
  }
  return $thumb;
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

function showArticle($array) {
	$article = $array[0];
	$imgsize = $array[1];
	$tweet = $array[2];
	//echo '<pre>',print_r($array),'</pre>';
    include( TEMPLATEPATH."/news/news-article.php");
}

add_filter('acf/settings/google_api_key', function () {
    return 'AIzaSyAwMGIq6u3sb-KRECLaJN2tHPlBa7fgymw';
});


/**** SEND TO LEADERSHIP TEMPLATE ***/
function get_custom_cat_template($single_template) {
   global $post;
   if ( in_category( 'leadership' )) {
      $single_template = dirname( __FILE__ ) . '/single-leadership.php';
   }
   return $single_template;
} 
add_filter( "single_template", "get_custom_cat_template" ) ;



/**** RESTRICT CATEGORY SELECTION IN BIOS ***/

function filterCats($listCats){
    global $typenow;    
    if($typenow=='ourpeople'){
        foreach ($listCats as $k => $oCat) {
            if( $oCat->term_id != 453){
                unset($listCats[$k]);
            }
        }
     }
     return $listCats;
 }
 add_filter('get_terms','filterCats');
 
 function getAuthors(){
 	global $wpdb;
	$results = $wpdb->get_results( "SELECT p.id, p.post_title FROM wp_n3lba9npwo_posts p "
 								 . "inner join wp_n3lba9npwo_postmeta m " 
								 . "on (m.meta_key = 'author' and m.meta_value = p.id) " 
							     . "or (m.meta_key = 'authors' and m.meta_value like concat('%\"', p.id, '\"%')) "
							     . "inner join wp_n3lba9npwo_posts ap on m.post_id = ap.id "
								 . "where p.post_type = 'ourpeople' " 
								 . "and ap.post_status = 'publish' "
								 . "group by p.id, p.post_title "
								 . "order by p.post_title" );
	return $results;					
 }
 
 function smw_author_query_vars_filter( $vars ){
   $vars[] = "a";
   return $vars;
 }
 add_filter( 'query_vars', 'smw_author_query_vars_filter' );
 
 function smw_author_pre_get_posts( $query ) {
	if ( !is_admin() && $query->is_main_query() && get_query_var("a") ) {
		$author = get_query_var("a");
		$metaQuery = array( 'relation'=>'OR', 
			array(
				'key'=>'author',
				'value'=>$author
			),
			array(
				'key'=>'authors',
				'value'=>'"' . $author . '"',
				'compare'=>'LIKE'
			) );
		$query->set('meta_query', $metaQuery);
	}
	return $query;
 }
 add_action('pre_get_posts', 'smw_author_pre_get_posts');
 
 function smw_subscribe_shortcode()
 {
 	$ppp = get_permalink('2203');
 	
 	$output = "<form action='$ppp' method='post' id='subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank' novalidate>"
		. "<p><input type='text' value=''  id='mce-FNAME' name='FNAME' class='required' id='mce-FNAME' placeholder='First Name'></p>"
		. "<p><input type='text' value='' id='mce-LNAME' name='LNAME' class='required' id='mce-LNAME' placeholder='Last Name'></p>"
		. "<p><input type='text' value=''  id='mce-EMAIL' name='EMAIL' class='required email' id='mce-EMAIL' placeholder='E-mail Address'></p>"
		. "<p><button type='submit' name='subscribe'>Subscribe</button></p>"
		. "</form>"
		. "<div class='svg-loader'>"
		. "<svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'"
		. "	 viewBox='0 0 50 50' style='enable-background:new 0 0 50 50;' xml:space='preserve'>"
		. "<style type='text/css'>"
		. "</style>"
		. "<rect x='24' width='2' height='16' id='rect1'/>"
		. "<rect x='15.5' y='2.3' transform='matrix(0.866 -0.5 0.5 0.866 -2.9282 9.6269)' width='2' height='16' id='rect2'/>"
		. "<rect x='9.3' y='8.5' transform='matrix(0.5 -0.866 0.866 0.5 -9.1506 17.1506)' width='2' height='16' id='rect3'/>"
		. "<rect x='7' y='17' transform='matrix(4.547480e-11 -1 1 4.547480e-11 -17 33)' width='2' height='16' id='rect4'/>"
		. "<rect x='9.3' y='25.5' transform='matrix(-0.5 -0.866 0.866 -0.5 -13.5955 59.1506)' width='2' height='16' id='rect5'/>"
		. "<rect x='15.5' y='31.7' transform='matrix(-0.866 -0.5 0.5 -0.866 10.9282 82.3731)' width='2' height='16' id='rect6'/>"
		. "<rect x='24' y='34' transform='matrix(-1 -8.913061e-11 8.913061e-11 -1 50 84)' width='2' height='16' id='rect7'/>"
		. "<rect x='32.5' y='31.7' transform='matrix(-0.866 0.5 -0.5 -0.866 82.3731 57.3731)' width='2' height='16' id='rect8'/>"
		. "<rect x='38.7' y='25.5' transform='matrix(-0.5 0.866 -0.866 -0.5 88.5955 15.8494)' width='2' height='16' id='rect9'/>"
		. "<rect x='41' y='17' transform='matrix(-1.336959e-10 1 -1 -1.336959e-10 67 -17)' width='2' height='16' id='rect10'/>"
		. "<rect x='38.7' y='8.5' transform='matrix(0.5 0.866 -0.866 0.5 34.1506 -26.1506)' width='2' height='16' id='rect11'/>"
		. "<rect x='32.5' y='2.3' transform='matrix(0.866 0.5 -0.5 0.866 9.6269 -15.3731)' width='2' height='16' id='rect12'/>"
		. "</svg>"
		. "</div>"
		;
		 
	return $output;
 }
 add_shortcode( 'SubscribeForm', 'smw_subscribe_shortcode' );
?>
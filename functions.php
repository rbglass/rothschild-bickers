<?php if ( ! defined( 'ABSPATH' ) ) exit; /* Exit if accessed directly */

add_action( 'after_setup_theme', 'rb_theme_setup' );

function rb_theme_setup() {
  /* Add theme support for automatic feed links. */ 
  add_theme_support( 'automatic-feed-links' );

  /* Add theme support for post thumbnails (featured images). */
  add_theme_support( 'post-thumbnails' );

  /* Add custom image sizes. */
  add_image_size( 'small-thumb', 488, 285, true );
  add_image_size( 'download-thumb', 460 ); 
  add_image_size( 'lrg_size', 1200 ); 
  add_image_size( 'mid_size', 800 ); 
  add_image_size( 'sml_size', 460 ); 
  add_image_size( 'src_size', 1200 ); 

  /* Add your nav menus function to the 'init' action hook. */
  add_action( 'init', 'rb_register_menus' );

  /* Add your sidebars function to the 'widgets_init' action hook. */
  add_action( 'widgets_init', 'rb_register_sidebars' );

  /* Add custom jQuery function to the 'init' action hook. */
  add_action( 'wp_enqueue_scripts', 'rb_jquery' );

  /* Load CSS files on the 'wp_enqueue_scripts' action hook. */
  add_action( 'wp_enqueue_scripts', 'rb_load_styles' );

  /* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
  add_action( 'wp_enqueue_scripts', 'rb_load_scripts' );

  /* Add remove_head_links function to the 'init' action hook. */
  add_action( 'init', 'rb_remove_head_links' );

  /* Allow SVG to allowed upload mimes */
  add_filter('upload_mimes', 'rb_upload_mimes');

  /* Custom excerpt length */
  add_filter( 'excerpt_length', 'rb_excerpt_length', 999 );

  /* Remove Admin Bar */
  add_filter('show_admin_bar', '__return_false');

  /* Remove the Wordpress generator tag */
  remove_action('wp_head', 'wp_generator');

  /* Pagination */
  add_action( 'pagination', 'rb_pagination' );

  /* SEO Locale */
  add_filter('wpseo_locale', 'override_og_locale');

  /* Remove <p> Tags on images */
  add_filter('the_content', 'filter_ptags_on_images');

  /* Title Tag Support */
  add_theme_support( 'title-tag' );

  /* Remove Emoji Styles */
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );

  /* Admin Styles */
  add_action('admin_head', 'custom_admin');

  // Don't strip editor
  add_filter('tiny_mce_before_init', 'mod_mce');
}

function rb_register_menus() {
  register_nav_menus(
    array(
      'main-menu' => __( 'Main Menu', 'wordpress' )
    )
  );
}

function rb_register_sidebars() {
  /* Register dynamic sidebars using register_sidebar() here. */
  register_sidebar(array(
    'name' => 'Footer',
    'id'   => 'e_footer',
    'description'   => 'Footer Widget Area',
    'before_widget' => '<div class="widget section">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));
}

function rb_jquery() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, '1.9.1', '' );
  wp_enqueue_script( 'jquery' );
}

function rb_load_styles()
{
  wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', false, false, 'all' );
  wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', false, false, 'all' );
  wp_enqueue_style( 'normalize' );
  wp_enqueue_style( 'fontawesome' );
  wp_enqueue_style( 'style', get_stylesheet_uri(), array(), rand(111,9999), 'all' );
}

function rb_load_scripts() {
  /* Enqueue custom Javascript here using wp_enqueue_script(). */
  wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '', true);
  wp_enqueue_script('init', get_template_directory_uri() . '/js/init.js', array('jquery'), '', true);
}

function rb_remove_head_links() {
  /* Removes unneccesary header links */
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
}

function rb_upload_mimes ( $existing_mimes=array() ) {
  // add the file extension to the array
  $existing_mimes['svg'] = 'mime/type';
  $existing_mimes['ico'] = 'mime/type';
  // call the modified list of extensions
  return $existing_mimes;
}

function rb_excerpt_length( $length ) {
  return 20;
}

function override_og_locale($locale)
{
  return "en_GB";
}

function rb_pagination($prev = '»', $next = '«') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'type' => 'plain'
);
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    echo paginate_links( $pagination );
}

function siblings($link) {
    global $post;
    $siblings = get_pages('child_of='.$post->post_parent.'&parent='.$post->post_parent);
    foreach ($siblings as $key=>$sibling){
        if ($post->ID == $sibling->ID){
            $ID = $key;
        }
    }
    $closest = array('before'=>get_permalink($siblings[$ID-1]->ID),'after'=>get_permalink($siblings[$ID+1]->ID));

    if ($link == 'before' || $link == 'after') { echo $closest[$link]; } else { return $closest; }
}

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function custom_admin() {
   echo '<style type="text/css">
           .et_builder_option { display:none; }
         </style>';
}

function mod_mce($initArray) {
  $initArray['verify_html'] = false;
  return $initArray;
}

function add_filters( $filters ) {
    $filters[] = 'et_lb_image';
    return $filters; // Equals array( 'the_content', 'post_thumbnail_html', 'my_custom_filter' )
}
add_filter( 'rwp_add_filters', 'add_filters' ); 

function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
?>
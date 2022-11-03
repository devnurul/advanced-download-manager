<?php
/**
 * Plugin Name:       Advanced Download Manager
 * Plugin URI:        https://wordpress.org/plugins/advanced-download-manager/
 * Description:       Advanced Download Manager is very strong download manager plugin. It allows you to digital download anything.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Dev. Nurul
 * Author URI:        https://devnurul.me
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       adma
 * Domain Path:       admn
 */


/**
 * start pf style link
 */
function admn_style() {
	wp_enqueue_style( 'admn-font-style', 'https://fonts.googleapis.com/css?family=Quicksand:400,700' );
	wp_enqueue_style( 'admn-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' );
	wp_enqueue_style( 'admin-styke', plugins_url( 'css/admn-style.css', __FILE__ ));
   
}
add_action( 'wp_enqueue_scripts', 'admn_style' );

/**
 * end of style link
 */
/**
 * Custom post type for downloads
 */
if ( ! function_exists('admn_downloads') ) {

    // Register Custom Post Type
    function admn_downloads() {
    
        $labels = array(
            'name'                  => _x( 'Downloads', 'Post Type General Name', 'admn' ),
            'singular_name'         => _x( 'Download', 'Post Type Singular Name', 'admn' ),
            'menu_name'             => __( 'Downloads', 'admn' ),
            'name_admin_bar'        => __( 'Download', 'admn' ),
            'archives'              => __( 'Item Archives', 'admn' ),
            'attributes'            => __( 'Item Attributes', 'admn' ),
            'parent_item_colon'     => __( 'Parent Item:', 'admn' ),
            'all_items'             => __( 'All Items', 'admn' ),
            'add_new_item'          => __( 'Add New Item', 'admn' ),
            'add_new'               => __( 'Add New', 'admn' ),
            'new_item'              => __( 'New Item', 'admn' ),
            'edit_item'             => __( 'Edit Item', 'admn' ),
            'update_item'           => __( 'Update Item', 'admn' ),
            'view_item'             => __( 'View Item', 'admn' ),
            'view_items'            => __( 'View Items', 'admn' ),
            'search_items'          => __( 'Search Item', 'admn' ),
            'not_found'             => __( 'Not found', 'admn' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'admn' ),
            'featured_image'        => __( 'Featured Image', 'admn' ),
            'set_featured_image'    => __( 'Set featured image', 'admn' ),
            'remove_featured_image' => __( 'Remove featured image', 'admn' ),
            'use_featured_image'    => __( 'Use as featured image', 'admn' ),
            'insert_into_item'      => __( 'Insert into item', 'admn' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'admn' ),
            'items_list'            => __( 'Items list', 'admn' ),
            'items_list_navigation' => __( 'Items list navigation', 'admn' ),
            'filter_items_list'     => __( 'Filter items list', 'admn' ),
        );
        $args = array(
            'label'                 => __( 'Download', 'admn' ),
            'description'           => __( 'Post Type for downloads', 'admn' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_icon'             => 'dashicons-download',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'admn-downloads', $args );
    
    }
    add_action( 'init', 'admn_downloads', 0 );
    
    } 

 /**
 * end Custom post type for downloads
 * start custom query
 */

    function admn_downloads_show(){
    ?>
        <div class="main-grid">
            <ul class="cards">
<?php
// WP_Query arguments
$args = array(
	'post_type'              => array( 'admn-downloads' ),
	'post_status'            => array( 'publish' ),
);

// The Query
$admn_query = new WP_Query( $args );

// The Loop
if ( $admn_query->have_posts() ) {
	while ( $admn_query->have_posts() ) {
		$admn_query->the_post();
		// do something
        ?>
        <li class="cards_item">
            <div class="card">
              <div class="card_image"><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); 
?>"></div>
              <div class="card_content">
                <h2 class="card_title"><?php the_title()?></h2>
                <table border="1px solid #ddd" width="100%" >
                    <tr style="padding: 2px 10px;">
                        <th style="padding: 5px 10px;">Updated</th>
                        <th style="padding: 5px 10px;">Version</th>
                        <th style="padding: 5px 10px;"><span><i class="fa-solid fa-circle-down"></i></span></th>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px;"><?php echo get_the_modified_time('d M y')?></td>
                        <td style="padding: 5px 10px;"><?php echo get_post_meta( get_the_ID(), 'version', true ); ?></td>
                        <td style="padding: 5px 10px;"><?php echo get_post_meta( get_the_ID(), 'total-download', true ); ?></td>
                    </tr>
                </table>
                         <button class="btnm card_btnm"> <a href="<?php echo get_post_meta( get_the_ID(), 'download-link', true ); ?>">Download Now</a></button>
              </div>
            </div>
          </li>
        <?php
	}
} else {
	// no posts found
}

// Restore original Post Data
wp_reset_postdata();

?>
  </ul>
</div>
<?php
};


    function admn_downloads_grid_show(){
            add_shortcode('DOWNLOAD', 'admn_downloads_show' );
    };

    add_action('init', 'admn_downloads_grid_show');

 ?>


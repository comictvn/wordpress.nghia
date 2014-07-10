<?php
/**
 * Plugin Name: Tuts+ CRM
 * Plugin URI: #
 * Version: 1.0
 * Author: Tuts+
 * Author URI: http://code.tutsplus.com
 * Description: A simple CRM system for WordPress
 * License: GPL2
 */
include_once( 'advanced-custom-fields/acf.php' );
define( 'ACF_LITE', true );
class WPTutsCRM {
     
    /**
     * Constructor. Called when plugin is initialised
     */

    function WPTutsCRM() {
         add_action( 'init', array( $this, 'register_custom_post_type' ) );
	 add_action( 'plugins_loaded', array( $this, 'acf_fields' ) );
         add_filter( 'manage_edit-contact_columns', array( $this, 'add_table_columns' ) );
	 add_action( 'manage_contact_posts_custom_column', array( $this, 'output_table_columns_data'), 10, 2 );
         add_filter( 'manage_edit-contact_sortable_columns', array( $this, 'define_sortable_table_columns') );
	 add_shortcode( 'list-posts-basic', 'rmcc_post_listing_shortcode1' );   
         if ( is_admin() ) {
        add_filter( 'request', array( $this, 'orderby_sortable_table_columns' ) );
    }
    }
	function define_sortable_table_columns( $columns ) {
 
    $columns['email_address'] = 'email_address';
    $columns['phone_number'] = 'phone_number';
     
    return $columns;
     
}
function acf_fields() {
 
    if( function_exists( "register_field_group" ) ) {
        register_field_group(array (
            'id' => 'acf_contact-details',
            'title' => 'Contact Details',
            'fields' => array (
                array (
                    'key' => 'field_5323276db7e18',
                    'label' => 'Email Address',
                    'name' => 'email_address',
                    'type' => 'email',
                    'required' => 1,
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array (
                    'key' => 'field_53232a6cf3800',
                    'label' => 'Phone Number',
                    'name' => 'phone_number',
                    'type' => 'number',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
                array (
                    'key' => 'field_53232aa9f3801',
                    'label' => 'Photo',
                    'name' => 'photo',
                    'type' => 'image',
                    'save_format' => 'object',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ),
                array (
                    'key' => 'field_53232c2ff3802',
                    'label' => 'Type',
                    'name' => 'type',
                    'type' => 'select',
                    'required' => 1,
                    'choices' => array (
                        'Prospect' => 'Prospect',
                        'Customer' => 'Customer',
                    ),
                    'default_value' => '',
                    'allow_null' => 0,
                    'multiple' => 0,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'contact',
                        'order_no' => 0,
                        'group_no' => 0,
                    ),
                ),
            ),
            'options' => array (
                'position' => 'normal',
                'layout' => 'default',
                'hide_on_screen' => array (
                    0 => 'permalink',
                    1 => 'excerpt',
                    2 => 'custom_fields',
                    3 => 'discussion',
                    4 => 'comments',
                    5 => 'revisions',
                    6 => 'slug',
                    7 => 'author',
                    8 => 'format',
                    9 => 'featured_image',
                    10 => 'categories',
                    11 => 'tags',
                    12 => 'send-trackbacks',
                ),
            ),
            'menu_order' => 1,
        ));
    }
}
function orderby_sortable_table_columns( $vars ) {
 
    // Don't do anything if we are not on the Contact Custom Post Type
    if ( 'contact' != $vars['post_type'] ) return $vars;
     
    // Don't do anything if no orderby parameter is set
    if ( ! isset( $vars['orderby'] ) ) return $vars;
     
    // Check if the orderby parameter matches one of our sortable columns
    if ( $vars['orderby'] == 'email_address' OR
        $vars['orderby'] == 'phone_number' ) {
        // Add orderby meta_value and meta_key parameters to the query
        $vars = array_merge( $vars, array(
            'meta_key' => $vars['orderby'],
            'orderby' => 'meta_value',
        ));
    }
     
    return $vars;
     
}	
   function add_table_columns( $columns ) {
 
    $columns['email_address'] = __( 'Email Address', 'tuts-crm' );
    $columns['phone_number'] = __( 'Phone Number', 'tuts-crm' );
    $columns['photo'] = __( 'Photo', 'tuts-crm' );
     
    return $columns;
     
    }
    function output_table_columns_data( $columnName, $post_id ) {
 
    // Field
    $field = get_field( $columnName, $post_id );
     
    if ( 'photo' == $columnName ) {
        echo '<img src="' . $field['sizes']['thumbnail'].'" width="'.$field['sizes']['thumbnail-width'] . '" height="' . $field['sizes']['thumbnail-height'] . '" />';
    } else {
        // Output field
        echo $field;
    }
     
}
	
    function register_custom_post_type() {
    register_post_type('contact', array(
        'labels' => array(
            'name'               => _x( 'Contacts', 'post type general name', 'tuts-crm' ),
            'singular_name'      => _x( 'Contact', 'post type singular name', 'tuts-crm' ),
            'menu_name'          => _x( 'Contacts', 'admin menu', 'tuts-crm' ),
            'name_admin_bar'     => _x( 'Contact', 'add new on admin bar', 'tuts-crm' ),
            'add_new'            => _x( 'Add New', 'contact', 'tuts-crm' ),
            'add_new_item'       => __( 'Add New Contact', 'tuts-crm' ),
            'new_item'           => __( 'New Contact', 'tuts-crm' ),
            'edit_item'          => __( 'Edit Contact', 'tuts-crm' ),
            'view_item'          => __( 'View Contact', 'tuts-crm' ),
            'all_items'          => __( 'All Contacts', 'tuts-crm' ),
            'search_items'       => __( 'Search Contacts', 'tuts-crm' ),
            'parent_item_colon'  => __( 'Parent Contacts:', 'tuts-crm' ),
            'not_found'          => __( 'No conttacts found.', 'tuts-crm' ),
            'not_found_in_trash' => __( 'No contacts found in Trash.', 'tuts-crm' ),
        ),
         
        // Frontend
        'has_archive'        => false,
        'public'             => false,
        'publicly_queryable' => false,
         
        // Admin
        'capability_type' => 'post',
        'menu_icon'     => 'dashicons-businessman',
        'menu_position' => 10,
        'query_var'     => true,
        'show_in_menu'  => true,
        'show_ui'       => true,
        'supports'      => array(
            'title',
            'author',
            'comments', 
        ),
	
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, false thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => '', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post' //
    )); 
}


   
}
// create shortcode to list all clothes which come in blue
add_shortcode( 'list-posts-basic', 'rmcc_post_listing_shortcode1' );
function rmcc_post_listing_shortcode1( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'contact',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );
    if ( $query->have_posts() ) { ?>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php echo get_post_meta( 58,'phone_number', true  ); ?>
		<?php echo $query->the_post() ?>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}
$wpTutsCRM = new WPTutsCRM;

?>
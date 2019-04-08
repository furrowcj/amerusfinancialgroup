<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'animate','owl-carousel','nivo-lightbox' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

include('custom-shortcodes.php');

add_action('init', function() {
/**
 * Add new fields above 'Update' button.
 *
 
* @param WP_User $user User object.
 */
function additional_profile_fields( $user ) {
	
$rank = wp_parse_args( get_the_author_meta( 'rank', $user->ID ), "Field Agent" );
    
$agent_above = wp_parse_args( get_the_author_meta( 'agent_above', $user->ID ), "" );

$agent_under1 = wp_parse_args( get_the_author_meta( 'agent_under1', $user->ID ), "" );

$agent_under2 = wp_parse_args( get_the_author_meta( 'agent_under2', $user->ID ), "" );

$agent_under3 = wp_parse_args( get_the_author_meta( 'agent_under3', $user->ID ), "" );

$agent_under4 = wp_parse_args( get_the_author_meta( 'agent_under4', $user->ID ), "" );

$agent_under5 = wp_parse_args( get_the_author_meta( 'agent_under5', $user->ID ), "" );

    ?>
    
<h3>Extra profile information</h3>

    
<table class="form-table">
   	 <tr>
   		 
<th><label for="rank">Rank</label></th>
   		 
<td>
   			 <select id="rank" name="rank">
<option value="">Select...</option>
<option value="Field Agent">Field Agent</option>
<option value="District Manager">District Manager</option>
<option value="Regional Manager">Regional Manager</option>
</select>
   		 
</td>
   	 
</tr>
	 
<tr>
		 
<th><label for="agent_above">Agent Manager</label></th>
		 
<td><input type="text" name="agent_above">   				 
   			 
</td>
</tr>
<tr>
		 
<th><label for="agent_under1">Hired Agent 1</label></th>
		 
<td><input type="text" name="agent_under1">   				 
   			 
</td>
</tr>
<tr>
		 
<th><label for="agent_under2">Hired Agent 2</label></th>
		 
<td><input type="text" name="agent_under2">   				 
   			 
</td>
</tr>

<tr>
		 
<th><label for="agent_under3">Hired Agent 3</label></th>
		 
<td><input type="text" name="agent_under3">   				 
   			 
</td>
</tr>
<tr>
		 
<th><label for="agent_under4">Hired Agent 4</label></th>
		 
<td><input type="text" name="agent_under4">   				 
   			 
</td>
</tr>
<tr>
		 
<th><label for="agent_under5">Hired Agent 5</label></th>
		 
<td><input type="text" name="agent_under5">   				 
   			 
</td>
</tr>
    
</table>
    <?php
}



/**
 * Save additional profile fields.
 *
 * @param  int $user_id Current user ID.
 */
function save_profile_fields( $user_id ) {

    if ( ! current_user_can( 'edit_user', $user_id ) ) {
   	 return false;
    }

    update_usermeta( $user_id, 'rank', $_POST['rank'] );
    update_usermeta( $user_id, 'agent_above', $_POST['agent_above'] );
    update_usermeta( $user_id, 'agent_under1', $_POST['agent_under1'] );
    update_usermeta( $user_id, 'agent_under2', $_POST['agent_under2'] );
    update_usermeta( $user_id, 'agent_under3', $_POST['agent_under3'] );
    update_usermeta( $user_id, 'agent_under4', $_POST['agent_under4'] );
    update_usermeta( $user_id, 'agent_under5', $_POST['agent_under5'] );
}

add_action( 'show_user_profile', 'additional_profile_fields' );
add_action( 'edit_user_profile', 'additional_profile_fields' );
add_action( 'personal_options_update', 'save_profile_fields' );
add_action( 'edit_user_profile_update', 'save_profile_fields' );
});


add_action( 'template_redirect', 'wc_custom_redirect_after_purchase' );
function wc_custom_redirect_after_purchase() {
    if ( ! is_wc_endpoint_url( 'order-received' ) ) return;

    // Define the product IDs in this array
    $product_ids = array( 343 ); // or an empty array if not used
    // Define the product categories (can be IDs, slugs or names)
    $product_categories = array(); // or an empty array if not used
    $redirection = false;

    global $wp;
    $order_id =  intval( str_replace( 'checkout/order-received/', '', $wp->request ) ); // Order ID
    $order = wc_get_order( $order_id ); // Get an instance of the WC_Order Object

    // Iterating through order items and finding targeted products
    foreach( $order->get_items() as $item ){
        if( in_array( $item->get_product_id(), $product_ids ) || has_term( $product_categories, 'product_cat', $item->get_product_id() ) ) {
            $redirection = true;
            break;
        }
    }

    // Make the custom redirection when a targeted product has been found in the order
    if( $redirection ){
        wp_redirect( home_url( '/website-registration/' ) );
        exit;
    }
}

// only copy opening php tag if needed
// Adds "per package" after each product price throughout the shop
function sv_change_product_price_display( $price ) {
	$price .= ' per item';
	return $price;
}
add_filter( 'woocommerce_get_price_html', 'sv_change_product_price_display' );
add_filter( 'woocommerce_cart_item_price', 'sv_change_product_price_display' );




function get_topfive() {
	$topfive = array();

	for ($x = 0;$x < 5;$x++)
{
	$subusers = get_users( 'blog_id=2&role=subscriber&exclude=$topfive' );
	$topuser = 0;
	$lastproduction = 0;
	foreach ($subusers as $user)
	{
		$user_id = ($user->ID);
		$yrlyproduction = get_user_meta( $user_id,'yrlyproduction',True );
		if ($yrlyproduction > $lastproduction)
		{
			$topuser = $user_id;
		}
		$lastproduction = $yrlyproduction;	
	}
	array_push($topfive, $topuser);
}
return $topfive;
}




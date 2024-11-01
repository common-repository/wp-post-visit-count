<?php 

/*
	Plugin Name: WP Post Visit Count
	Author: Rajesh Kumar Sharma
	Author URI: http://sitextensions.com
	Version: 1.0
	Description: This plugin counts the post visits. Use 'post_views_count' meta key to get current post visit counts.
	Tags: Count Visits, Visit Count, Post Visit Count, Count, Visit
*/

define('WPVC_COUNT_KEY', 'post_views_count');
add_action('wp_head', 'use_post_views');
function use_post_views(){
	if(is_single()){
		wpvc_count_post_views(get_the_ID());
	}
}

//Set the Post Custom Field in the WP dashboard as Name/Value pair 
function wpvc_count_post_views($post_ID = '') {
	if($post_ID == ''){
		return false;
	}
    
	//Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, WPVC_COUNT_KEY, true);
     
    //If the the Post Custom Field value is empty. 
    if($count == ''){
        $count = 1; // set the counter to zero.
         
        //Delete all custom fields with the specified key from the specified post. 
        delete_post_meta($post_ID, WPVC_COUNT_KEY);
         
        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, WPVC_COUNT_KEY, '0');
        return $count . ' View';
     
    //If the the Post Custom Field value is NOT empty.
    }else{
        $count++; //increment the counter by 1.
        //Update the value of an existing meta key (custom field) for the specified post.
        update_post_meta($post_ID, WPVC_COUNT_KEY, $count);
         
        //If statement, is just to have the singular form 'View' for the value '1'
        if($count == '1'){
        return $count . ' View';
        }
        //In all other cases return (count) Views
        else {
			return $count . ' Views';
        }
    }
}

//Gets the  number of Post Views to be used later.
function wpvc_get_post_views($post_ID = ''){
	if($post_ID == ''){
		return false;
	}
	
    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, WPVC_COUNT_KEY, true);
    return $count;
}
 
//Hooks a function to a specific filter action.
//applied to the list of columns to print on the manage posts screen.
add_filter('manage_posts_columns', 'wpvc_post_column_views');
 
//Hooks a function to a specific action. 
//allows you to add custom columns to the list post/custom post type pages.
//'10' default: specify the function's priority.
//and '2' is the number of the functions' arguments.
add_action('manage_posts_custom_column', 'wpvc_post_custom_column_views',10,2);

//Function that Adds a 'Views' Column to your Posts tab in WordPress Dashboard.
function wpvc_post_column_views($newcolumn){
    //Retrieves the translated string, if translation exists, and assign it to the 'default' array.
    $newcolumn['post_views'] = __('Views');
    return $newcolumn;
}
 
//Function that Populates the 'Views' Column with the number of views count.
function wpvc_post_custom_column_views($column_name, $id){
     
    if($column_name === 'post_views'){
        // Display the Post View Count of the current post.
        // get_the_ID() - Returns the numeric ID of the current post.
        echo wpvc_get_post_views(get_the_ID());
    }
}

/* ================================================================================================================= */
// Add settings page forchoose post type.
/* ================================================================================================================= */


// Ad options page in settings menu in wp.
add_action( 'admin_menu', 'wpvc_options_page' );
function wpvc_options_page() {
	add_options_page( 
		'Post Visit Count', // Title to show in menu
		'WP Post Visit Count', // Title to ahow in title bar
		'manage_options',  // PLugin can do
		'wpvc_options', // Slug for page
		'wpvc_options_page_callback' // function that you want to call on this slug
	);
}

// Set callback for options page
function wpvc_options_page_callback(){
	?>
		<div class="wrap">
			<h2>WP Post Visit Count Options</h2>
			<!-- Future work will take action here -->
		</div>
	<?php 
}




















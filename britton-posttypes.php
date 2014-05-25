<?php
/**
 * Plugin Name: Add Movie Review Post Type and Taxonomies
 * Description: A brief description of the Plugin.
 * Version: 0.1
 * Author: Morten Rand-Hendriksen
 * Author URI: http://mor10.com
 * License: GPL2
 */

/*  Copyright 2014  Morten Rand-Hendriksen  (email : morten@pinkandyellow.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* 
 * Creates a post type for Movie reviews
 * Also sets up 5 custom taxonomies
 */

add_action( 'init', 'mortens_reviews_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function mortens_reviews_init() {
	$labels = array(
		'name'               => 'Reviews',
		'singular_name'      => 'Review',
		'menu_name'          => 'Reviews',
		'name_admin_bar'     => 'Review',
		'add_new'            => 'Add new',
		'add_new_item'       => 'Add New Review',
		'new_item'           => 'New Review',
		'edit_item'          => 'Edit Review',
		'view_item'          => 'View Review',
		'all_items'          => 'All Reviews',
		'search_items'       => 'Search Reviews',
		'parent_item_colon'  => 'Parent Reviews',
		'not_found'          => 'No Reviews Found',
		'not_found_in_trash' => 'No reviews found in Trash',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
                'menu_icon'          => 'dashicons-star-half',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'reviews' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'review', $args );
}


function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    mortens_reviews_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );





// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_review_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_review_taxonomies() {
	
        // Add Genre taxonomy
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Genres' ),
		'all_items'         => __( 'All Genres' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Edit Genre' ),
		'update_item'       => __( 'Update Genre' ),
		'add_new_item'      => __( 'Add New Genre' ),
		'new_item_name'     => __( 'New Genre Name' ),
		'menu_name'         => __( 'Genre' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genres' ),
	);

	register_taxonomy( 'genre', array( 'review' ), $args );
        
        
        // Add Year of Release taxonomy
	$labels = array(
		'name'              => _x( 'Years of Release', 'taxonomy general name' ),
		'singular_name'     => _x( 'Year of Release', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Years of Release' ),
		'all_items'         => __( 'All Years of Release' ),
		'parent_item'       => __( 'Parent Year of Release' ),
		'parent_item_colon' => __( 'Parent Year of Release:' ),
		'edit_item'         => __( 'Edit Year of Release' ),
		'update_item'       => __( 'Update Year of Release' ),
		'add_new_item'      => __( 'Add New Year of Release' ),
		'new_item_name'     => __( 'New Year of Release Name' ),
		'menu_name'         => __( 'Year of Release' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'release-years' ),
	);

	register_taxonomy( 'release_year', array( 'review' ), $args );
        
        // Add Rating
	$labels = array(
		'name'              => _x( 'Ratings', 'taxonomy general name' ),
		'singular_name'     => _x( 'Rating', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Ratings' ),
		'all_items'         => __( 'All Ratings' ),
		'parent_item'       => __( 'Parent Rating' ),
		'parent_item_colon' => __( 'Parent Rating:' ),
		'edit_item'         => __( 'Edit Rating' ),
		'update_item'       => __( 'Update Rating' ),
		'add_new_item'      => __( 'Add New Rating' ),
		'new_item_name'     => __( 'New Rating Name' ),
		'menu_name'         => __( 'Rating' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'ratings' ),
	);

	register_taxonomy( 'rating', array( 'review' ), $args );
        
        // Add Mood taxonomy
	$labels = array(
		'name'                       => 'Moods',
		'singular_name'              => 'Mood',
		'search_items'               => 'Search Moods',
		'popular_items'              => 'Popular Moods',
		'all_items'                  => 'All Moods',
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit Mood',
		'update_item'                => 'Update Mood',
		'add_new_item'               => 'Add New Mood',
		'new_item_name'              => 'New Mood Name',
		'separate_items_with_commas' => 'Separate Moods with commas',
		'add_or_remove_items'        => 'Add or remove Moods',
		'choose_from_most_used'      => 'Choose from the most used Moods',
		'not_found'                  => 'No Moods found',
		'menu_name'                  => 'Moods',
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'moods' ),
	);

	register_taxonomy( 'mood', 'review', $args );
        
        // Add Features taxonomy
	$labels = array(
		'name'                       => 'Features',
		'singular_name'              => 'Feature',
		'search_items'               => 'Search Features',
		'popular_items'              => 'Popular Features',
		'all_items'                  => 'All Features',
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit Feature',
		'update_item'                => 'Update Feature',
		'add_new_item'               => 'Add New Feature',
		'new_item_name'              => 'New Feature Name',
		'separate_items_with_commas' => 'Separate Features with commas',
		'add_or_remove_items'        => 'Add or remove Features',
		'choose_from_most_used'      => 'Choose from the most used Features',
		'not_found'                  => 'No Features found',
		'menu_name'                  => 'Features',
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'features' ),
	);

	register_taxonomy( 'feature', 'review', $args );
}
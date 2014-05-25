<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_image_size( 'poster-single', 350, 539, true );

function get_rating($post_ID){
    // Get ratings term(s)
    $terms = get_the_terms( $post_ID, 'rating' );
    
    // Check to make sure we actually have rating terms
    if( $terms && ! is_wp_error( $terms ) ){
        // Get just the first term object
        $term = array_shift($terms);
        // Set the term name (rating number) as the variable $rating
        $rating = $term->name;

        // Output tickets to match the number
        echo '<div class="ratings movie-tax">';
        echo '<h4 class="movie-data-title">Rating</h4>';
        echo '<a href="' . get_term_link( $term->slug, 'rating' ) . '" title="' . get_the_title($post_ID) . ' gets ' . $rating . ' of 5 tickets.">';
        
        // Output one black ticket for each number (3 equals 3 tickets)
        for ($ticket = 0 ; $ticket < $rating; $ticket++){ 
            echo '<i class="fa fa-ticket"></i>'; 
        }
        // Output grey tickets for the remainder (5 - 3 = 2 tickets)
        for ($no_ticket = $rating ; $no_ticket < 5 ; $no_ticket++){
            echo '<i class="fa fa-ticket grey"></i>'; 
        }
        
        echo '</a>';
        echo '</div>';
    } // Endif
}

function my_add_reviews( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ($query->is_home() || $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'review' ) );
        }
    }
}

add_action( 'pre_get_posts', 'my_add_reviews' );
<?php
/**
 * Plugin Name: Lahmacun Search Post
 * Description: Add post code meta box
 * Author: Mustafa Zahid EFE
 * Version: 1.0.0
 */

function lahmacun_search_meta_box() {
    add_meta_box(
        'lahmacun_post_code',
        __( 'Post Short Code', 'lahmacun' ),
        'lahmacun_search_meta_box_callback',
        'post',
		'side'
    );
}

add_action( 'add_meta_boxes', 'lahmacun_search_meta_box' );

function lahmacun_search_meta_box_callback($post) {
	    $value = get_post_meta( $post->ID, 'lahmacun_post_code', true );
	    echo '<input type="text" value="' . $value . '" name="lahmacun_post_code" class="widefat" />';
}

function save_lahmacun_post_code( $post_id ) {
    if ( ! isset( $_POST['lahmacun_post_code'] ) ) {
        return;
    }
	
    $my_data = sanitize_text_field( $_POST['lahmacun_post_code'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'lahmacun_post_code', $my_data );
}

add_action( 'save_post', 'save_lahmacun_post_code' );

if( ! function_exists( 'post_meta_request_params' ) ) :
	function post_meta_request_params( $args, $request )
	{
		$args += array(
			'meta_key'   => $request['meta_key'],
			'meta_value' => $request['meta_value'],
			'meta_query' => $request['meta_query'],
		);
	    return $args;
	}
	add_filter( 'rest_post_query', 'post_meta_request_params', 99, 2 );
endif;

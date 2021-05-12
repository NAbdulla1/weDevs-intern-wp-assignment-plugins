<?php


namespace A07_Book_Review;


class Books_CPT {
	public function __construct() {
		add_action( 'init', [ $this, 'register_book_custom_post_type' ] );
		add_action( 'save_post', [ $this, 'set_default_category' ] );
	}

	public function register_book_custom_post_type() {
		$labels = array(
			'name'               => _x( 'Books', 'post type general name' ),
			'singular_name'      => _x( 'Book', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add New Book' ),
			'edit_item'          => __( 'Edit Book' ),
			'new_item'           => __( 'New Book' ),
			'all_items'          => __( 'All Books' ),
			'view_item'          => __( 'View Book' ),
			'search_items'       => __( 'Search Books' ),
			'not_found'          => __( 'No books found' ),
			'not_found_in_trash' => __( 'No books found in the Trash' ),
			'menu_name'          => 'Books'
		);
		$args   = array(
			'labels'      => $labels,
			'description' => 'Holds our books and book specific data',
			'public'      => true,
			'has_archive' => true,
		);
		register_post_type( 'a07_book_review_book', $args );
	}

	/**
	 * sets default category of the book post as 'Uncategorized'
	 */
	public function set_default_category( $post_id ) {
		wp_set_object_terms( $post_id, '1', 'category' );
	}
}

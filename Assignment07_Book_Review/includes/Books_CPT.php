<?php


namespace A07_Book_Review;


class Books_CPT {
	public function __construct() {
		add_action( 'init', [ $this, 'register_book_custom_post_type' ] );
		add_action( 'save_post', [ $this, 'set_default_category' ] );
	}

	public function register_book_custom_post_type() {
		$labels = array(
			'name'               => esc_html_x( 'Books', 'post type general name', 'a07_book_review_text_domain'),
			'singular_name'      => esc_html_x( 'Book', 'post type singular name', 'a07_book_review_text_domain'),
			'add_new'            => esc_html_x( 'Add New', 'book', 'a07_book_review_text_domain'),
			'add_new_item'       => esc_html__( 'Add New Book', 'a07_book_review_text_domain'),
			'edit_item'          => esc_html__( 'Edit Book', 'a07_book_review_text_domain'),
			'new_item'           => esc_html__( 'New Book', 'a07_book_review_text_domain'),
			'all_items'          => esc_html__( 'All Books', 'a07_book_review_text_domain'),
			'view_item'          => esc_html__( 'View Book', 'a07_book_review_text_domain'),
			'search_items'       => esc_html__( 'Search Books', 'a07_book_review_text_domain'),
			'not_found'          => esc_html__( 'No books found', 'a07_book_review_text_domain'),
			'not_found_in_trash' => esc_html__( 'No books found in the Trash', 'a07_book_review_text_domain'),
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
	 *
	 * @param $post_id
	 */
	public function set_default_category( $post_id ) {
		wp_set_object_terms( $post_id, 'Uncategorized', 'category' );
	}
}

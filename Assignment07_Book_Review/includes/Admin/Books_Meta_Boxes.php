<?php


namespace A07_Book_Review\Admin;

/**
 * Class Books_Meta_Boxes
 * @package A07_Book_Review\Admin
 */
class Books_Meta_Boxes {
	/**
	 * Books_Meta_Boxes constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_books_cpt_boxes' ] );
		add_action( 'save_post', [ $this, 'save_books_cpt_boxes_meta' ] );
	}

	/**
	 * Callback to add book custom post boxes
	 */
	public function add_books_cpt_boxes() {
		add_meta_box( 'a07_book_review_metabox', 'Books Meta', [
			$this,
			'html'
		], 'a07_book_review_book', 'side' );//screen name is same as cpt
	}

	/**
	 * @param \WP_Post $post
	 */
	public function html( \WP_Post $post ) {
		$author    = get_post_meta( $post->ID, '_a07_book_review_author_field_value', true );
		$author    = ( empty( $author ) ? '' : $author );
		$publisher = get_post_meta( $post->ID, '_a07_book_review_publisher_field_value', true );
		$publisher = ( empty( $publisher ) ? '' : $publisher );
		echo "<label>Author: </label><input  type='text' style='width: 100%' name='_a07_book_review_author_field' value='$author' placeholder='Author' />
			<br /><label>Publisher: </label><input  type='text' style='width: 100%' name='_a07_book_review_publisher_field' value='$publisher' placeholder='Publisher' />";
	}

	/**
	 * @param $post_id
	 */
	public function save_books_cpt_boxes_meta( $post_id ) {
		if ( array_key_exists( '_a07_book_review_author_field', $_POST )
		     && ! empty( trim( $_POST['_a07_book_review_author_field'] ) ) ) {
			update_post_meta( $post_id, '_a07_book_review_author_field_value', $_POST['_a07_book_review_author_field'] );
		}
		if ( array_key_exists( '_a07_book_review_publisher_field', $_POST )
		     && ! empty( trim( $_POST['_a07_book_review_publisher_field'] ) ) ) {
			update_post_meta( $post_id, '_a07_book_review_publisher_field_value', $_POST['_a07_book_review_publisher_field'] );
		}
	}
}

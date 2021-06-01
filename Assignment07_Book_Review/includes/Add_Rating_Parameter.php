<?php


namespace A07_Book_Review;

/**
 * Class Add_Rating_Parameter Adds rewrite rule to access rating of a Book_CPT
 * @package A07_Book_Review
 */
class Add_Rating_Parameter {
	/**
	 * Add_Rating_Parameter constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'rewrite_book_url_with_rating' ), 1, 0 );
	}

	/**
	 * Callback to register the parameter and the the rewrite rule
	 */
	public function rewrite_book_url_with_rating() {
		add_rewrite_rule(
			'^a07_book_review_book/([^/]+)/a07_br_rating/?$',
			'index.php?a07_book_review_book=$matches[1]&a07_br_rating=true',
			'top'
		);
		add_rewrite_tag( '%a07_br_rating%', '[^/]+' );
	}
}

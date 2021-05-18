<?php


namespace A07_Book_Review;

use A05_Contact_Form\Log;
use A07_Book_Review\Frontend\Copy_Custom_Post_Template;
use A07_Book_Review\Frontend\Search_Book_By_Meta;

class Frontend {
	public function __construct() {
		new Copy_Custom_Post_Template();
		new Search_Book_By_Meta();

		add_action( 'wp_enqueue_scripts', [ $this, 'loadScript' ] );
	}

	public function loadScript() {
		if ( is_single() ) {
			wp_enqueue_script( 'a07_book_review_rate_script' );
		}
	}
}
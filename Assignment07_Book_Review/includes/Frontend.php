<?php

namespace A07_Book_Review;

use A07_Book_Review\Frontend\Book_Rating_Shortcode;
use A07_Book_Review\Frontend\Copy_Custom_Post_Template;
use A07_Book_Review\Frontend\Rating_Parameter_Handler;
use A07_Book_Review\Frontend\Search_Book_By_Meta;

/**
 * Class Frontend
 * @package A07_Book_Review
 */
class Frontend {
	/**
	 * Frontend constructor.
	 */
	public function __construct() {
		new Copy_Custom_Post_Template();
		new Search_Book_By_Meta();
		new Rating_Parameter_Handler();
		new Book_Rating_Shortcode();
		add_action( 'wp_enqueue_scripts', [ $this, 'loadScript' ] );
	}

	/**
	 * Load the necessary script in frontend
	 */
	public function loadScript() {
		if ( is_single() ) {
			wp_enqueue_script( 'a07_book_review_rate_script' );
		}
	}
}
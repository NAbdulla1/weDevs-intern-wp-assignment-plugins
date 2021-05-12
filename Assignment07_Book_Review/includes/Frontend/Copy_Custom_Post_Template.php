<?php


namespace A07_Book_Review\Frontend;


use A06_Post_Excerpt\Log;

class Copy_Custom_Post_Template {
	public function __construct() {
		add_action( 'init', [ $this, 'copy_custom_template_files' ] );
	}

	public function copy_custom_template_files() {
		copy( A07_BOOK_REVIEW_PATH . '/assets/theme-files/single-a07_book_review_book.php',
			get_template_directory() . '/single-a07_book_review_book.php' );
		copy( A07_BOOK_REVIEW_PATH . '/assets/theme-files/content-single-a07_book_review_book.php',
			get_template_directory() . '/template-parts/content/single-a07_book_review_book.php' );
	}
}
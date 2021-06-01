<?php

namespace A07_Book_Review\Frontend;

/**
 * Class Rating_Parameter_Handler
 * @package A07_Book_Review\Frontend
 */
class Rating_Parameter_Handler {
	/**
	 * Rating_Parameter_Handler constructor.
	 */
	public function __construct() {
		add_filter( 'the_content', array( $this, 'filter_content' ) );
	}

	/**
	 * Searches for a07_br_rating in current request.
	 * If it present then return a shortcode that will show the current book's raging,
	 * otherwise the original content will be returned without any change
	 *
	 * @param string $content The page content.
	 *
	 * @return mixed|string
	 */
	public function filter_content( $content ) {
		remove_filter( 'the_content', array( $this, 'filter_content' ) );
		$cc = get_query_var( 'a07_br_rating' ); // for testing that if I am getting the parameter value
		if ( empty( $cc ) ) {
			return $content;
		} else {
			// show rating instead of post content
			return '[' . Book_Rating_Shortcode::TAG . ']';
		}
	}
}

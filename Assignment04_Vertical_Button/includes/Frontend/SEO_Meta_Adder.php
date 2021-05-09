<?php


namespace A04_Vertical_Button\Frontend;

/**
 * Class SEO_Meta_Adder
 * @package A04_Vertical_Button\Frontend
 */
class SEO_Meta_Adder {
	/**
	 * SEO_Meta_Adder constructor. registers an Action to work on the header
	 */
	public function __construct() {
		add_action( 'wp_head', [ $this, 'add_meta' ] );
	}

	/**
	 * adds a meta information in the header section
	 */
	public function add_meta() {
		echo "\n<meta data-plugin='a04_vertical_button' name='description' content='a sample meta description for this website'/>\n\n";
	}
}
<?php


namespace A04_Vertical_Button;


use A04_Vertical_Button\Frontend\Frontend_Vertical_Button;
use A04_Vertical_Button\Frontend\SEO_Meta_Adder;

/**
 * Plugin activity for the frontend
 * @package A04_Vertical_Button
 */
class Frontend {
	public function __construct() {
		new Frontend_Vertical_Button();
		new SEO_Meta_Adder();
	}
}
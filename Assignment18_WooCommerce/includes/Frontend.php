<?php


namespace A18_WooCommerce;


use A17_STUDENT_INFO\Frontend\Student_Info_Display_Shortcode;
use A17_STUDENT_INFO\Frontend\Student_Input_Shortcode;
use A18_WooCommerce\Frontend\Add_To_Cart_At_Visit;
use A18_WooCommerce\Frontend\Recent_Product_Tab;

/**
 * Manages frontend specific features
 * Class Frontend
 * @package A18_WooCommerce
 */
class Frontend {
	public function __construct() {
		new Recent_Product_Tab();
		new Add_To_Cart_At_Visit();
	}
}
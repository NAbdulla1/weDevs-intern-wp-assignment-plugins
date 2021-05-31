<?php


namespace A18_WooCommerce;

use A18_WooCommerce\Frontend\Add_To_Cart_At_Visit;
use A18_WooCommerce\Frontend\Customized_Checkout;
use A18_WooCommerce\Frontend\Related_Products_Tab;

/**
 * Manages frontend specific features
 * Class Frontend
 *
 * @package A18_WooCommerce
 */
class Frontend {
	/**
	 * Constructor
	 */
	public function __construct() {
		new Assets();
		new Related_Products_Tab();
		new Add_To_Cart_At_Visit();
		new Customized_Checkout();
	}
}

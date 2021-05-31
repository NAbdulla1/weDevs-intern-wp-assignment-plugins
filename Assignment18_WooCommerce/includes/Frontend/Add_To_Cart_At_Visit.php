<?php


namespace A18_WooCommerce\Frontend;

/**
 * A class to specity Add-to-cart on visit
 */
class Add_To_Cart_At_Visit {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'woocommerce_single_product_summary', array( $this, 'add_to_cart' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_cart' ) );
	}

	/**
	 * The callback of the hook to perform add-to-cart operation
	 *
	 * @return void
	 */
	public function add_to_cart() {
		if ( is_single() ) {
			global $woocommerce;
			$cart = $woocommerce->cart->get_cart();
			global $product;
			$in_cart = false;
			foreach ( $cart as $key => $value ) {
				if ( $value['product_id'] === $product->get_id() ) {
					$in_cart = true;
					break;
				}
			}
			if ( ! $in_cart ) {
				$woocommerce->cart->add_to_cart( $product->get_id(), 1 );
			}
		}
	}

	/**
	 * Load a script to update the cart amount and items after page loaded
	 *
	 * @return void
	 */
	public function load_cart() {
		wp_enqueue_script( 'cart-refresh-script' );
	}
}

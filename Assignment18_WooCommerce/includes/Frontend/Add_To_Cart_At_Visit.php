<?php


namespace A18_WooCommerce\Frontend;


class Add_To_Cart_At_Visit {
	public function __construct() {
		add_action( 'woocommerce_single_product_summary', [ $this, 'add_to_cart' ] );
	}

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
}
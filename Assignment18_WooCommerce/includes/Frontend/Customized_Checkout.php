<?php

namespace A18_WooCommerce\Frontend;

/**
 * A class to customize the checkout page into 2 parts
 */
class Customized_Checkout {
	/**
	 * Constructor to register hooks
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'eqnueue_assets' ) );
		add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'before_customer_details' ) );
		add_action( 'woocommerce_after_order_notes', array( $this, 'after_customer_details' ) );
		add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'before_customer_details' ) );
		add_action( 'woocommerce_checkout_after_order_review', array( $this, 'after_order_review' ) );
	}

	/**
	 * Equeue scripts and styles
	 *
	 * @return void
	 */
	public function eqnueue_assets() {
		wp_enqueue_script( 'checkout-tab-script' );
		wp_enqueue_style( 'checkout-tab-style' );
	}

	/**
	 * Start of part 1 and part 2 of the checkout form
	 *
	 * @return void
	 */
	public function before_customer_details() {
		echo '<div class="checkout-tab">';
	}

	/**
	 * End of part 1 of the checkout form
	 *
	 * @return void
	 */
	public function after_customer_details() {
		echo '<button id="nextBtn" type="button">';
		esc_html_e( 'Next Part', 'a18-woocommerce-td' );
		echo '</button>';
		echo '</div>';
	}

	/**
	 * End of part 2 of checkout form
	 *
	 * @return void
	 */
	public function after_order_review() {
		echo '<button id="prevBtn" type="button">';
		esc_html_e( 'Previous Part', 'a18-woocommerce-td' );
		echo '</button>';
		echo '</div>';
	}
}

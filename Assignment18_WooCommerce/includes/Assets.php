<?php


namespace A18_WooCommerce;

/**
 * Handles static asset like js or css
 */
class Assets {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'localize_cart_refresh' ), );
	}

	/**
	 * Register scripts
	 *
	 * @return void
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		foreach ( $scripts as $handle => $asset ) {
			wp_register_script( $handle, $asset['src'], $asset['deps'], $asset['version'], true );
		}

		$styles = $this->get_style();
		foreach ( $styles as $handle => $asset ) {
			wp_register_style( $handle, $asset['src'], $asset['deps'], $asset['version'], false );
		}
	}

	/**
	 * Prepares and attaches localize objects for JS scripts
	 *
	 * @return void
	 */
	public function localize_cart_refresh() {
		wp_localize_script(
			'cart-refresh-script',
			'a18_wc_cart_ref',
			array(
				'cart_url' => '/wp-json/wc/store/cart',
			)
		);
	}

	/**
	 * Prepare and return the script files
	 *
	 * @return array
	 */
	public function get_scripts() : array {
		return array(
			'checkout-tab-script' => array(
				'src'     => A18_WOOCOMMERCE_ASSETS . '/js/checkout_tab_maintainer.js',
				'deps'    => array(),
				'version' => filemtime( A18_WOOCOMMERCE_PATH . '/assets/js/checkout_tab_maintainer.js' ),
			),
			'cart-refresh-script' => array(
				'src'     => A18_WOOCOMMERCE_ASSETS . '/js/cart_refresh.js',
				'deps'    => array(),
				'version' => filemtime( A18_WOOCOMMERCE_PATH . '/assets/js/cart_refresh.js' ),
			),
		);
	}

	/**
	 * Prepare and return the style files
	 *
	 * @return array
	 */
	public function get_style() {
		return array(
			'checkout-tab-style' => array(
				'src'     => A18_WOOCOMMERCE_ASSETS . '/css/checkout_tab_style.css',
				'deps'    => array(),
				'version' => filemtime( A18_WOOCOMMERCE_PATH . '/assets/css/checkout_tab_style.css' ),
			),
		);
	}
}

<?php

/**
 * Plugin Name: Assignment19 Customerer Total Purchase
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment19-Customer-Total-Purchase
 * Description: A plugin to work with woocommerce
 * Version: 1.0
 * Author: Md. Abdulla Al Mamun
 * Author URI: https://github.com/NAbdulla1
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * License: GPLv2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once 'vendor/autoload.php';

/**
 * Class A19_Customer_Total_Purchase
 */
class A19_Customer_Total_Purchase {
	const VERSION = '1.0';

	/**
	 * A19_Customer_Total_Purchase constructor.
	 */
	public function __construct() {
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		$this->define_constants();

		add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * @return A19_Customer_Total_Purchase|false
	 */
	public static function init() {
		$instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define constants to use later
	 */
	private function define_constants() {
		define( 'A19_CUSTOMER_TOTAL_PURCHASE_VERSION', self::VERSION );
		define( 'A19_CUSTOMER_TOTAL_PURCHASE_PATH', __DIR__ );
		define( 'A19_CUSTOMER_TOTAL_PURCHASE_FILE', __FILE__ );
		define( 'A19_CUSTOMER_TOTAL_PURCHASE_URL', plugins_url( '', A19_CUSTOMER_TOTAL_PURCHASE_FILE ) );
		define( 'A19_CUSTOMER_TOTAL_PURCHASE_ASSETS', A19_CUSTOMER_TOTAL_PURCHASE_URL . '/assets' );
	}

	/**
	 * Activation action for the plugin
	 */
	public function activate() {
		$installed_on = get_option( 'a19_customer_total_purchase_installed' );
		if ( ! $installed_on ) {
			update_option( 'a19_customer_total_purchase_installed', time() );
		}
		update_option( 'a19_customer_total_purchase_version', self::VERSION );
	}

	/**
	 * Do some action after plugin loaded
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			new \A19_Custom_Total_Purchase\Admin();
		}
	}
}

/**
 * A helper function
 */
function a19_customer_total_purchase() {
	A19_Customer_Total_Purchase::init();
}

/**
 * Plugin entrypoint
 */
a19_customer_total_purchase();


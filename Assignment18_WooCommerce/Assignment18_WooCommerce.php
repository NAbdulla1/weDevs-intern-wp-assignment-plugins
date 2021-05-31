<?php
/**
 * Plugin Name: Assignment18 WooCommerce
 * Description: A plugin to practice woocommerce modification
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment18_WooCommerce
 * Author: Md. Abdulla Al Mamun
 * Author URI: https://github.com/NAbdulla1
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package A18_WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Entry point class of this plugin. this is a singleton class
 */
class Assignment18_WooCommerce {
	/**
	 * Current VERSION of the plugin
	 */
	const VERSION = '1.0';

	/**
	 * Assignment18_WooCommerce constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * Ensures singleton characteristics of this class
	 *
	 * @return Assignment18_WooCommerce|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define constants to use throughout the plugin
	 */
	public function define_constants() {
		define( 'A18_WOOCOMMERCE_VERSION', self::VERSION );
		define( 'A18_WOOCOMMERCE_FILE', __FILE__ );
		define( 'A18_WOOCOMMERCE_PATH', __DIR__ );
		define( 'A18_WOOCOMMERCE_URL', plugins_url( '', A18_WOOCOMMERCE_FILE ) );
		define( 'A18_WOOCOMMERCE_ASSETS', A18_WOOCOMMERCE_URL . '/assets' );
		define( 'A18_WOOCOMMERCE_TD', 'a18_woocommerce_text_domain' );
	}

	/**
	 * Plugin activation hook callback
	 */
	public function activate() {
		( new \A18_WooCommerce\Installer() )->run();
	}

	/**
	 * Start initializing plugin after plugin loaded
	 */
	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A18_WooCommerce\Frontend();
		}
	}
}

/**
 * A helper function
 */
function a18_woocommerce() {
	Assignment18_WooCommerce::init();
}

a18_woocommerce();

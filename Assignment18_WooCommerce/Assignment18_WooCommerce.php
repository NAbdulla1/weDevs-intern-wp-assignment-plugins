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
	 * current version of the plugin
	 */
	const version = '1.0';

	/**
	 * Assignment18_WooCommerce constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * ensures singleton characteristics of this class
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
	 * define constants to use throughout the plugin
	 */
	public function define_constants() {
		define( "A18_WOOCOMMERCE_VERSION", self::version );
		define( "A18_WOOCOMMERCE_FILE", __FILE__ );
		define( "A18_WOOCOMMERCE_PATH", __DIR__ );
		define( "A18_WOOCOMMERCE_URL", plugins_url( '', A18_WOOCOMMERCE_FILE ) );
		define( "A18_WOOCOMMERCE_ASSETS", A18_WOOCOMMERCE_URL . '/assets' );
		define( "A18_WOOCOMMERCE_TD", 'a18_woocommerce_text_domain' );
	}

	/**
	 * plugin activation hook callback
	 */
	public function activate() {
		( new \A18_WooCommerce\Installer() )->run();
	}

	/**
	 * start initializing plugin after plugin loaded
	 */
	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A18_WooCommerce\Frontend();
		}
	}
}

/**
 * a helper function
 */
function a18_woocommerce() {
	Assignment18_WooCommerce::init();
}

a18_woocommerce();

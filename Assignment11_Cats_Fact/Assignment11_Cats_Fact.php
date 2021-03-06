<?php

/**
 * @package NAbdulla
 * Plugin Name: Assignment11 Cats Fact
 * Description: A plugin to work with dashboard widget and http api
 * Short Description: a short description
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment11_Cats_Fact
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
 * A class to manage the plugin
 */
class Assignment11_Cats_Fact {

	const VERSION = '1.0';

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * Ensure singleton
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define constants to use later
	 */
	private function define_constants() {
		define( 'A11_CF_VERSION', self::VERSION );
		define( 'A11_CF_FILE', __FILE__ );
		define( 'A11_CF_PATH', __DIR__ );
		define( 'A11_CF_URL', plugins_url( '', A11_CF_FILE ) );
		define( 'A11_CF_ASSETS', A11_CF_URL . '/assets' );
		define( 'A11_CF_TD', 'a11_cf_text_domain' );
	}

	/**
	 * Do some action during activation
	 */
	public function activate() {
		$installed = get_option( 'a11_cf_installed', false );
		if ( ! $installed ) {
			update_option( 'a11_cf_installed', time() );
		}
		update_option( 'a11_cf_version', A11_CF_VERSION );
	}

	/**
	 * Initialize plugin
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			new \A11_CF\Admin();
		}
	}
}

/**
 * A helper function
 */
function a11_cf() {
	Assignment11_Cats_Fact::init();
}
/**
 * The entrypoint of the plugin
 */
a11_cf();

<?php
/**
 * Plugin Name: Assignment16 REST CRUD practice
 * Description: A plugin to a vertical button at middle right of screen
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment16_REST_CRUD
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
class Assignment16_REST_CRUD {
	/**
	 * current version of the plugin
	 */
	const version = '1.0';

	/**
	 * Assignment16_REST_CRUD constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * ensures singleton characteristics of this class
	 *
	 * @return Assignment16_REST_CRUD|false
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
		define( "A16_REST_CRUD_VERSION", self::version );
		define( "A16_REST_CRUD_FILE", __FILE__ );
		define( "A16_REST_CRUD_PATH", __DIR__ );
		define( "A16_REST_CRUD_URL", plugins_url( '', A16_REST_CRUD_FILE ) );
		define( "A16_REST_CRUD_ASSETS", A16_REST_CRUD_URL . '/assets' );
		define( "A16_REST_CRUD_TD", 'a16_rest_crud_text_domain' );
	}

	/**
	 * plugin activation hook callback
	 */
	public function activate() {
		( new \A16_Rest_CRUD_Mango\Installer() )->run();
	}

	/**
	 * start initializing plugin after plugin loaded
	 */
	public function init_plugin() {
		new \A16_Rest_CRUD_Mango\Api();
	}
}

/**
 * a helper function
 */
function a16_rest_crud() {
	Assignment16_REST_CRUD::init();
}

a16_rest_crud();

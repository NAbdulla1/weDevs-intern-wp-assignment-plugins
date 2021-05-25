<?php
/**
 * Plugin Name: Assignment17 Student Info
 * Description: A plugin to a vertical button at middle right of screen
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment17_Student_Info
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
class Assignment17_Student_Info {
	/**
	 * current version of the plugin
	 */
	const version = '1.0';

	/**
	 * Assignment17_Student_Info constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * ensures singleton characteristics of this class
	 *
	 * @return Assignment17_Student_Info|false
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
		define( "A17_STUDENT_INFO_VERSION", self::version );
		define( "A17_STUDENT_INFO_FILE", __FILE__ );
		define( "A17_STUDENT_INFO_PATH", __DIR__ );
		define( "A17_STUDENT_INFO_URL", plugins_url( '', A17_STUDENT_INFO_FILE ) );
		define( "A17_STUDENT_INFO_ASSETS", A17_STUDENT_INFO_URL . '/assets' );
		define( "A17_STUDENT_INFO_TD", 'a17_student_info_text_domain' );
	}

	/**
	 * plugin activation hook callback
	 */
	public function activate() {
		( new \A17_STUDENT_INFO\Installer() )->run();
	}

	/**
	 * start initializing plugin after plugin loaded
	 */
	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A17_STUDENT_INFO\Frontend();
		}
	}
}

/**
 * a helper function
 */
function a17_student_info() {
	Assignment17_Student_Info::init();
}

a17_student_info();

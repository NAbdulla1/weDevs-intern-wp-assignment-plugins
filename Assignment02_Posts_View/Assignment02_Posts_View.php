<?php
/**
 * Plugin Name: Assignment02 Posts View
 * Description: A plugin to count posts view
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment02_Posts_View
 * Author: Md. Abdulla Al Mamun
 * Author URI: https://github.com/NAbdulla1
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: a02_posts_view_textdomain
 */

require_once __DIR__ . "/vendor/autoload.php";

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Assignment02_Posts_View
 */
final class Assignment02_Posts_View {
	const version = '1.0';

	/**
	 * Assignment02_Posts_View constructor.
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate_plugin' ] );

		add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * @return Assignment02_Posts_View|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define constants to user later
	 */
	private function define_constants() {
		define( 'A02_Posts_View_VERSION', self::version );
		define( 'A02_Posts_View_FILE', __FILE__ );
		define( 'A02_Posts_View_PATH', __DIR__ );
		define( 'A02_Posts_View_URL', plugins_url( '', A02_Posts_View_FILE ) );
		define( 'A02_Posts_View_ASSETS', '/assets' );
	}

	/**
	 * Store some information during activation
	 */
	public function activate_plugin() {
		$installed = get_option( 'A02_Posts_View_installed', false );
		if ( ! $installed ) {
			update_option( 'A02_Posts_View_installed', time() );
		}
		update_option( 'A02_Posts_View_version', A02_Posts_View_VERSION );
	}

	/**
	 * Initialize plugin after loaded
	 */
	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A02_Posts_View_Counter\Frontend();
		}
	}
}

/**
 * @return Assignment02_Posts_View|false
 */
function a02_posts_view() {
	return Assignment02_Posts_View::init();
}

/**
 * Entry point
 */
a02_posts_view();

<?php
/**
 * Plugin Name: Assignment08 Featured Posts
 * Description: A plugin to work with settings api and object caching
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment08_Featured_Posts
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
 * Class Assignment08_Featured_Posts
 */
class Assignment08_Featured_Posts {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * ensures a singleton is provided
	 * @return Assignment08_Featured_Posts|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * defines constants to use later
	 */
	private function define_constants() {
		define( "A08_FEATURED_POSTS_VERSION", self::version );
		define( "A08_FEATURED_POSTS_FILE", __FILE__ );
		define( "A08_FEATURED_POSTS_PATH", __DIR__ );
		define( "A08_FEATURED_POSTS_URL", plugins_url( '', A08_FEATURED_POSTS_FILE ) );
		define( "A08_FEATURED_POSTS_ASSETS", A08_FEATURED_POSTS_URL . '/assets' );
	}

	/**
	 * stores some information during activation of the plugin
	 */
	public function activate() {
		$installed = get_option( 'a08_featured_posts_installed', false );
		if ( ! $installed ) {
			update_option( 'a08_featured_posts_installed', time() );
		}
		update_option( 'a08_featured_posts_version', A08_FEATURED_POSTS_VERSION );
	}

	/**
	 * executes constituent parts of the plugin as necessary
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			new \A08_Featured_Post\Admin();
		} else {
			new \A08_Featured_Post\Frontend();
		}
	}
}

/**
 * a helper function
 */
function a08_featured_posts() {
	Assignment08_Featured_Posts::init();
}

/**
 * entry point of the plugin
 */
a08_featured_posts();

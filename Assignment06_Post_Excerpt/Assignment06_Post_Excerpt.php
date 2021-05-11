<?php
/**
 * Plugin Name: Assignment06 Post Excerpt
 * Description: A plugin to add and display post excerpt
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment06_Post_Excerpt
 * Author: Md. Abdulla Al Mamun
 * Author URI: https://github.com/NAbdulla1
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';

class Assignment06_Post_Excerpt {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	private function define_constants() {
		define( "A06_POST_EXCERPT_VERSION", self::version );
		define( "A06_POST_EXCERPT_FILE", __FILE__ );
		define( "A06_POST_EXCERPT_PATH", __DIR__ );
		define( "A06_POST_EXCERPT_URL", plugins_url( '', A06_POST_EXCERPT_FILE ) );
		define( "A06_POST_EXCERPT_ASSETS", A06_POST_EXCERPT_URL . '/assets' );
	}

	public function activate() {
		$installed = get_option( 'a06_post_excerpt_installed', false );
		if ( ! $installed ) {
			update_option( 'a06_post_excerpt_installed', time() );
		}
		update_option( 'a06_post_excerpt_version', A06_POST_EXCERPT_VERSION );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new \A06_Post_Excerpt\Admin();
		} else {
			new \A06_Post_Excerpt\Frontend();
		}
	}
}

function a06_post_excerpt() {
	Assignment06_Post_Excerpt::init();
}

a06_post_excerpt();
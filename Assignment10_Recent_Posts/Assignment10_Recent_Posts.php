<?php

/**
 * Plugin Name: Assignment10 Recent Posts
 * Description: A plugin to work with dashboard widget
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment10_Recent_Posts
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

class Assignment10_Recent_Posts {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	private function define_constants() {
		define( "A10_RECENT_POSTS_VERSION", self::version );
		define( "A10_RECENT_POSTS_FILE", __FILE__ );
		define( "A10_RECENT_POSTS_PATH", __DIR__ );
		define( "A10_RECENT_POSTS_URL", plugins_url( '', A10_RECENT_POSTS_FILE ) );
		define( "A10_RECENT_POSTS_ASSETS", A10_RECENT_POSTS_URL . '/assets' );
		define( 'A10_RECENT_POSTS_TD', 'a10_recent_posts_text_domain' );
	}

	public function activate() {
		$installed = get_option( 'a10_recent_posts_installed', false );
		if ( ! $installed ) {
			update_option( 'a10_recent_posts_installed', time() );
		}
		update_option( 'a10_recent_posts_version', A10_RECENT_POSTS_VERSION );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new \A10_RP\Admin();
		}
	}
}

function a10_recent_posts() {
	Assignment10_Recent_Posts::init();
}

a10_recent_posts();

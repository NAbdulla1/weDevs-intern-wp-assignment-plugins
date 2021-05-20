<?php

/**
 * Plugin Name: Assignment12 Related Posts
 * Description: A plugin to work with theme widget
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment12_Related_Posts
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

class Assignment12_Related_Posts {
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
		define( "A12_RELATED_POSTS_VERSION", self::version );
		define( "A12_RELATED_POSTS_FILE", __FILE__ );
		define( "A12_RELATED_POSTS_PATH", __DIR__ );
		define( "A12_RELATED_POSTS_URL", plugins_url( '', A12_RELATED_POSTS_FILE ) );
		define( "A12_RELATED_POSTS_ASSETS", A12_RELATED_POSTS_URL . '/assets' );
		define( 'A12_RELATED_POSTS_TD', 'a12_related_posts_text_domain' );
	}

	public function activate() {
		$installed = get_option( 'a12_related_posts_installed', false );
		if ( ! $installed ) {
			update_option( 'a12_related_posts_installed', time() );
		}
		update_option( 'a12_related_posts_version', A12_RELATED_POSTS_VERSION );
	}

	public function init_plugin() {
		new \A12_RELATED_POSTS\Widgets();
	}
}

function a12_related_posts() {
	Assignment12_Related_Posts::init();
}

a12_related_posts();

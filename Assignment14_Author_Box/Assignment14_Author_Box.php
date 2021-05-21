<?php

/**
 * Plugin Name: Assignment14 Author Box
 * Description: A plugin to work with author meta data
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment14_Author_Box
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

class Assignment14_Author_Box {
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
		define( "A14_AUTHOR_BOX_VERSION", self::version );
		define( "A14_AUTHOR_BOX_FILE", __FILE__ );
		define( "A14_AUTHOR_BOX_PATH", __DIR__ );
		define( "A14_AUTHOR_BOX_URL", plugins_url( '', A14_AUTHOR_BOX_FILE ) );
		define( "A14_AUTHOR_BOX_ASSETS", A14_AUTHOR_BOX_URL . '/assets' );
		define( 'A14_AUTHOR_BOX_TD', 'a14_author_box_text_domain' );
	}

	public function activate() {
		$installed = get_option( 'a14_author_box_installed', false );
		if ( ! $installed ) {
			update_option( 'a14_author_box_installed', time() );
		}
		update_option( 'a14_author_box_version', A14_AUTHOR_BOX_VERSION );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new A14_Author_Box\Admin();
		} else {
			new \A14_Author_Box\Frontend();
		}
	}
}

function a14_author_box() {
	Assignment14_Author_Box::init();
}

a14_author_box();

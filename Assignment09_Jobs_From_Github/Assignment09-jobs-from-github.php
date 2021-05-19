<?php

/**
 * Plugin Name: Assignment09 Jobs From Github
 * Description: A plugin to work with HTTP api
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment09_Jobs_From_Github
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

class Assignment09_Jobs_From_Github {
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
		define( "A09_JOBS_FROM_GITHUB_VERSION", self::version );
		define( "A09_JOBS_FROM_GITHUB_FILE", __FILE__ );
		define( "A09_JOBS_FROM_GITHUB_PATH", __DIR__ );
		define( "A09_JOBS_FROM_GITHUB_URL", plugins_url( '', A09_JOBS_FROM_GITHUB_FILE ) );
		define( "A09_JOBS_FROM_GITHUB_ASSETS", A09_JOBS_FROM_GITHUB_URL . '/assets' );
	}

	public function activate() {
		( new \A09_Jobs_From_Github\Installer() )->run();
	}

	public function init_plugin() {
		if ( is_admin() ) {

		} else {
			new \A09_Jobs_From_Github\Frontend();
		}
	}
}

function a09_jobs_from_github() {
	Assignment09_Jobs_From_Github::init();
}

a09_jobs_from_github();

<?php
/**
 * Plugin Name: Assignment07 Book Review
 * Description: A plugin to work with books and reviews
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment07_Book_Review
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

class Assignment07_Book_Review {

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
		define( "A07_BOOK_REVIEW_VERSION", self::version );
		define( "A07_BOOK_REVIEW_FILE", __FILE__ );
		define( "A07_BOOK_REVIEW_PATH", __DIR__ );
		define( "A07_BOOK_REVIEW_URL", plugins_url( '', A07_BOOK_REVIEW_FILE ) );
		define( "A07_BOOK_REVIEW_ASSETS", A07_BOOK_REVIEW_URL . '/assets' );
	}

	public function activate() {
		( new \A07_Book_Review\Installer() )->run();
	}

	public function init_plugin() {
		new \A07_Book_Review\Books_CPT();
		new \A07_Book_Review\Book_Types();
		new \A07_Book_Review\Assets();
		if ( wp_doing_ajax() ) {
			new \A07_Book_Review\Ajax();
		}
		if ( is_admin() ) {
			new \A07_Book_Review\Admin();
		} else {
			new \A07_Book_Review\Frontend();
		}
	}
}

function a07_book_review() {
	Assignment07_Book_Review::init();
}

a07_book_review();

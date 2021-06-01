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

/**
 * Class Assignment07_Book_Review
 */
class Assignment07_Book_Review {

	/**
	 * version of plugin
	 */
	const version = '1.0';

	/**
	 * Assignment07_Book_Review constructor.
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		add_action( 'plugin_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * @return Assignment07_Book_Review|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * define constants to use later
	 */
	private function define_constants() {
		define( 'A07_BOOK_REVIEW_VERSION', self::version );
		define( 'A07_BOOK_REVIEW_FILE', __FILE__ );
		define( 'A07_BOOK_REVIEW_PATH', __DIR__ );
		define( 'A07_BOOK_REVIEW_URL', plugins_url( '', A07_BOOK_REVIEW_FILE ) );
		define( 'A07_BOOK_REVIEW_ASSETS', A07_BOOK_REVIEW_URL . '/assets' );
	}

	/**
	 * activation hook callback
	 */
	public function activate() {
		( new \A07_Book_Review\Installer() )->run();
	}

	/**
	 * initialize plugin
	 */
	public function init_plugin() {
		new \A07_Book_Review\Books_CPT();
		new \A07_Book_Review\Book_Types();
		new A07_Book_Review\Add_Rating_Parameter();
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

/**
 * a helper function
 */
function a07_book_review() {
	Assignment07_Book_Review::init();
}

/**
 * entry point
 */
a07_book_review();

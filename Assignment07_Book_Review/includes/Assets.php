<?php


namespace A07_Book_Review;


/**
 * Class Assets Static asset like js css manageer
 * @package A07_Book_Review
 */
class Assets {
	/**
	 * Assets constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	/**
	 * Register the assets
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		foreach ( $scripts as $handle => $asset ) {
			wp_register_script( $handle, $asset['src'], $asset['deps'], $asset['version'], true );
		}

		wp_localize_script( 'a07_book_review_rate_script', 'book_review_info', [
			'post_id'     => get_the_ID(),
			'user_id'     => get_current_user_id(),
			'user_ip'     => $this->get_user_ip(),
			'action'      => 'a07_rating_save',
			'a07_r_nonce' => wp_create_nonce( 'a07_rating_save_act' ),
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		] );
	}

	/**
	 * Prepares and returns the scripts to user
	 * @return array[]
	 */
	public function get_scripts() {
		return [
			'a07_book_review_rate_script' => [
				'src'     => A07_BOOK_REVIEW_ASSETS . '/js/book_rating_storer.js',
				'version' => filemtime( A07_BOOK_REVIEW_PATH . '/assets/js/book_rating_storer.js' ),
				'deps'    => [ 'jquery' ],
			]
		];
	}

	/**
	 * Finds current user ip
	 * @return mixed
	 */
	function get_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}
}
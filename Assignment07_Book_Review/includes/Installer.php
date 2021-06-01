<?php


namespace A07_Book_Review;

/**
 * Class Installer
 * @package A07_Book_Review
 */
class Installer {
	/**
	 * Runs functions to Install
	 */
	public function run() {
		$this->save_version();
		$this->create_db_table();
	}

	/**
	 * Save the version and first installation time
	 */
	private function save_version() {
		$installed = get_option( 'a07_book_review_installed', false );
		if ( ! $installed ) {
			update_option( 'a07_book_review_installed', time() );
		}
		update_option( 'a07_book_review_version', A07_BOOK_REVIEW_VERSION );
	}

	/**
	 * Create db table if not exists
	 */
	private function create_db_table() {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();
		$schema  = "
		CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}a07_book_review_ratings`
			  (
			     `id`         INT NOT NULL auto_increment,
			     `user_id`    BIGINT NOT NULL,
			     `post_id`    BIGINT NOT NULL,
			     `rating`     INT NOT NULL,
			     `created_at` DATE NOT NULL,
			     `updated_at` DATE NOT NULL,
			     PRIMARY KEY (`id`)
			  ) $charset;
		";

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}
		dbDelta( $schema );
	}
}
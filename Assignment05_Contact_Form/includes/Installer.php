<?php


namespace A05_Contact_Form;


class Installer {
	public function run() {
		$this->save_version();
		$this->create_table();
	}

	private function save_version() {
		$installed = get_option( 'a05_contact_form_installed', false );
		if ( ! $installed ) {
			update_option( 'a05_contact_form_installed', time() );
		}
		update_option( 'a05_contact_form_version', A05_CONTACT_FORM_VERSION );
	}

	private function create_table() {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();
		$schema  = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}a05_contact_form`
					  (
					     `id`         INT UNSIGNED NOT NULL auto_increment,
					     `first_name` VARCHAR(100) NOT NULL,
					     `last_name`  VARCHAR(100) NOT NULL,
					     `email`      VARCHAR(100) NOT NULL,
					     `message`    VARCHAR(1000) NOT NULL,
					     PRIMARY KEY (`id`)
					  ) $charset";
		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}
		dbDelta( $schema );
	}
}
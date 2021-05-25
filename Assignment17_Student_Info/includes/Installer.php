<?php


namespace A17_STUDENT_INFO;

/**
 * Class Installer
 * This class does some action during activation of the plugin
 * @package A17_STUDENT_INFO
 */
class Installer {
	/**
	 * run the other functions to do installation
	 */
	public function run() {
		$this->store_install_info();
		$this->create_db_table();
	}

	/**
	 * store version and first install time of the plugin
	 */
	private function store_install_info() {
		$installed = get_option( 'a17_student_info_installed', false );
		if ( ! $installed ) {
			update_option( 'a17_student_info_installed', time() );
		}
		update_option( 'a17_student_info_version', A17_STUDENT_INFO_VERSION );
	}

	/**
	 * creates a database table if that is not exists to store necessary information
	 */
	private function create_db_table() {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();
		$schema  = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}a17_si_students`(
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `first_name` VARCHAR(100) NOT NULL ,
                        `last_name` VARCHAR(100) NULL , 
                        `class` VARCHAR(20) NOT NULL , 
                        `roll_no` VARCHAR(20) NOT NULL , 
                        `registration_no` VARCHAR(20) NULL ,
                        PRIMARY KEY (`id`)
                    ) $charset";

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}
		dbDelta( $schema );

		$object_name = 'a17_si_student';
		$table_name  = $wpdb->prefix . $object_name . 'meta';
		$schema      = "CREATE TABLE IF NOT EXISTS `$table_name` (
    						`meta_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
    						`a17_si_student_id` BIGINT UNSIGNED NOT NULL ,
    						`meta_key` VARCHAR(255) NULL ,
						    `meta_value` LONGTEXT NULL ,
						    PRIMARY KEY (`meta_id`)
						) $charset";
		dbDelta( $schema );
	}
}
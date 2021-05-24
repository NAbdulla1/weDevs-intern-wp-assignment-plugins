<?php


namespace A16_Rest_CRUD_Mango;

/**
 * Class Installer
 * This class does some action during activation of the plugin
 * @package A16_Rest_CRUD_Mango
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
		$installed = get_option( 'a16_rest_crud_installed', false );
		if ( ! $installed ) {
			update_option( 'a16_rest_crud_installed', time() );
		}
		update_option( 'a16_rest_crud_version', A16_REST_CRUD_VERSION );
	}

	/**
	 * creates a database table if that is not exists to store necessary information
	 */
	private function create_db_table() {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();
		$schema  = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}a16_rest_mangoes` ( 
    					`id` INT NOT NULL AUTO_INCREMENT , 
    					`name` VARCHAR(50) NOT NULL , 
    					`price_per_kg` DOUBLE NOT NULL , 
    					`origin_district` VARCHAR(30) NOT NULL , 
    					PRIMARY KEY (`id`)
                    ) $charset";
		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}
		dbDelta( $schema );
	}
}
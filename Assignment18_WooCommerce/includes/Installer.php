<?php


namespace A18_WooCommerce;

/**
 * Class Installer
 * This class does some action during activation of the plugin
 * @package A18_WooCommerce
 */
class Installer {
	/**
	 * run the other functions to do installation
	 */
	public function run() {
		$this->store_install_info();
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
}
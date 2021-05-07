<?php

namespace A01\i18n\Admin;

class Menu {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	public function admin_menu() {
		add_menu_page( __( 'weDevs Academy', 'a01-i18n' ), __( 'Academy', 'a01-i18n' ), 'manage_options', 'a01-i18n', [
			$this,
			'plugin_page'
		], 'dashicons-welcome-learn-more' );
	}

	public function plugin_page() {
		echo "Hello World";
	}
}
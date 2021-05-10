<?php
/**
 * Plugin Name: Assignment05 Contact Form
 * Description: A plugin to show a contact form
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment05_Contact_From
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

class Assignment05_Contact_From {
	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A05_Contact_Form\Frontend();
		}
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

function a05_contact_form() {
	Assignment05_Contact_From::init();
}

a05_contact_form();

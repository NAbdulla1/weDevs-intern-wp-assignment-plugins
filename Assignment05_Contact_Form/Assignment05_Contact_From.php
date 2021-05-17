<?php
/**
 * Plugin Name: Assignment05 Contact Form
 * Description: A plugin to show a contact form
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment05_Contact_Form
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
	const version = '1.0';

	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	public function init_plugin() {
		new \A05_Contact_Form\Assets();
		if ( defined( 'DOING_AJAX' ) ) {
			new \A05_Contact_Form\Ajax();
		}
		if ( ! is_admin() ) {
			new \A05_Contact_Form\Frontend();
		} else {
			new \A05_Contact_Form\Admin();
		}
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	private function define_constants() {
		define( "A05_CONTACT_FORM_VERSION", self::version );
		define( "A05_CONTACT_FORM_FILE", __FILE__ );
		define( "A05_CONTACT_FORM_PATH", __DIR__ );
		define( "A05_CONTACT_FORM_URL", plugins_url( '', A05_CONTACT_FORM_FILE ) );
		define( "A05_CONTACT_FORM_ASSETS", A05_CONTACT_FORM_URL . '/assets' );
	}

	public function activate() {
		$installer = new \A05_Contact_Form\Installer();
		$installer->run();
	}
}

function a05_contact_form() {
	Assignment05_Contact_From::init();
}

a05_contact_form();

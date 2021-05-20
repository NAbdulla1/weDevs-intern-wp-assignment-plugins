<?php

/**
 * Plugin Name: Assignment13 Subscription Form
 * Description: A plugin to work with theme widget, settings and api to store
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment13_Subscription_Form
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

class Assignment13_Subscription_Form {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	private function define_constants() {
		define( "A13_SUBSCRIPTION_FORM_VERSION", self::version );
		define( "A13_SUBSCRIPTION_FORM_FILE", __FILE__ );
		define( "A13_SUBSCRIPTION_FORM_PATH", __DIR__ );
		define( "A13_SUBSCRIPTION_FORM_URL", plugins_url( '', A13_SUBSCRIPTION_FORM_FILE ) );
		define( "A13_SUBSCRIPTION_FORM_ASSETS", A13_SUBSCRIPTION_FORM_URL . '/assets' );
		define( 'A13_SUBSCRIPTION_FORM_TD', 'a13_subscription_form_text_domain' );
	}

	public function activate() {
		$installed = get_option( 'a13_subscription_form_installed', false );
		if ( ! $installed ) {
			update_option( 'a13_subscription_form_installed', time() );
		}
		update_option( 'a13_subscription_form_version', A13_SUBSCRIPTION_FORM_VERSION );
	}

	public function init_plugin() {
		new \A13_Subscription_Form\Widgets();
		if ( is_admin() ) {
			new \A13_Subscription_Form\Admin();
		}
	}
}

function a13_subscription_form() {
	Assignment13_Subscription_Form::init();
}

a13_subscription_form();

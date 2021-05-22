<?php

/*
Plugin Name: Assignment15 Customer Reg Form
Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment15_Customer_Reg_Form
Description: A plugin to work with user roles and capabilities
Version: 1.0
Author: Md. Abdulla Al Mamun
Author URI: https://github.com/NAbdulla1/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Assignment15_Customer_Reg_Form {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	public function define_constants() {
		define( "A15_CUSTOMER_REG_FORM_VERSION", self::version );
		define( "A15_CUSTOMER_REG_FORM_FILE", __FILE__ );
		define( "A15_CUSTOMER_REG_FORM_PATH", __DIR__ );
		define( "A15_CUSTOMER_REG_FORM_URL", plugins_url( '', A15_CUSTOMER_REG_FORM_FILE ) );
		define( "A15_CUSTOMER_REG_FORM_ASSETS", A15_CUSTOMER_REG_FORM_URL . '/assets' );
		define( "A15_CUSTOMER_REG_FORM_TD", 'a15_customer_reg_form_text_domain' );
	}

	public function activate() {
		( new \A15_Customer_Reg_Form\Installer() )->run();
	}

	public function init_plugin() {
		if ( ! is_admin() ) {
			new \A15_Customer_Reg_Form\Frontend();
		}
	}
}

function a15_customer_reg_form() {
	Assignment15_Customer_Reg_Form::init();
}

a15_customer_reg_form();

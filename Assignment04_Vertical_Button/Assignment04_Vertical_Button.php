<?php
/**
 * Plugin Name: Assignment04 Vertical Button
 * Description: A plugin to a vertical button at middle right of screen
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment04_Vertical_Button
 * Author URI: https://github.com/NAbdulla1
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Entry point class of this plugin. this is a singleton class
 */
class Assignment04_Vertical_Button {

	/**
	 * Assignment04_Vertical_Button constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * @return Assignment04_Vertical_Button|false
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * plugin will start initializing from here. this will also call the custom hook.
	 */
	public function init_plugin() {
		if ( is_admin() ) {
			new \A04_Vertical_Button\Admin();
		} else {
			new \A04_Vertical_Button\Frontend();
		}
		do_action( 'a04_vertical_button_text', 'A Button' );
	}
}

/**
 * to access the singleton from other places
 * @return Assignment04_Vertical_Button|false
 */
function a04_vertical_button() {
	return Assignment04_Vertical_Button::init();
}

a04_vertical_button();
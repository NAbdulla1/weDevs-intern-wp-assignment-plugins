<?php
/**
 * Plugin Name: 01 - i18n
 * Description: A plugin for to test internationalization with gettext
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins
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

final class _01_i18n {
	const version = '1.0';

	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugin_loaded', [ $this, 'init_plugin' ] );
		add_filter( 'gettext', [ $this, 'addI18n' ], 10, 3 );
	}

	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	public function define_constants() {
		define( "WD_ACADEMY_VERSION", self::version );
		define( "WD_ACADEMY_FILE", __FILE__ );
		define( "WD_ACADEMY_PATH", __DIR__ );
		define( "WD_ACADEMY_URL", plugins_url( '', WD_ACADEMY_FILE ) );
		define( "WD_ACADEMY_ASSETS", WD_ACADEMY_URL . '/assets' );
	}

	public function activate() {
		$installed = get_option( 'wd_academy_installed', false );
		if ( ! $installed ) {
			update_option( 'wd_academy_installed', time() );
		}
		update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new \WeDevs\Academy\Admin();
		} else {
			new \WeDevs\Academy\Frontend();
		}
	}

	public function addI18n( $translated_text, $old_text, $domain ) {
		if ( $domain === 'wedevs-academy' && $old_text === 'weDevs Academy' ) {
			$translated_text = 'weDevs একাডেমি';
		}
		if ( $domain === 'wedevs-academy' && $old_text === 'Academy' ) {
			$translated_text = 'একাডেমি';
		}

		return $translated_text;
	}
}

function wedevs_academy() {
	return _01_i18n::init();
}

wedevs_academy();

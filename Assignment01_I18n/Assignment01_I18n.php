<?php
/**
 * Plugin Name: Assignment01_I18n
 * Description: A plugin for to test internationalization with gettext
 * Plugin URI: https://github.com/NAbdulla1/weDevs-intern-wp-assignment-plugins/tree/main/Assignment01_I18n
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

final class Assignment01_I18n {
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
		define( "A01_I18N_VERSION", self::version );
		define( "A01_I18N_FILE", __FILE__ );
		define( "A01_I18N_PATH", __DIR__ );
		define( "A01_I18N_URL", plugins_url( '', A01_I18N_FILE ) );
		define( "A01_I18N_ASSETS", A01_I18N_URL . '/assets' );
	}

	public function activate() {
		$installed = get_option( 'a01_i18n_installed', false );
		if ( ! $installed ) {
			update_option( 'a01_i18n_installed', time() );
		}
		update_option( 'a01_i18n_version', A01_I18N_VERSION );
	}

	public function init_plugin() {
		if ( is_admin() ) {
			new \A01\i18n\Admin();
		} else {
			new \A01\i18n\Frontend();
		}
	}

	public function addI18n( $translated_text, $old_text, $domain ) {
		if ( $domain === 'a01-i18n' && $old_text === 'weDevs Academy' ) {
			$translated_text = 'weDevs একাডেমি';
		}
		if ( $domain === 'a01-i18n' && $old_text === 'Academy' ) {
			$translated_text = 'একাডেমি';
		}

		return $translated_text;
	}
}

function a01_i18n() {
	return Assignment01_I18n::init();
}

a01_i18n();

<?php


namespace A05_Contact_Form;


class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	public function get_scripts(): array {
		return [
			'contact_form_script' => [
				'src'     => A05_CONTACT_FORM_ASSETS . '/js/a05_contact_form.js',
				'version' => filemtime( A05_CONTACT_FORM_PATH . '/assets/js/a05_contact_form.js' ),
			]
		];
	}

	public function register_assets() {
		$scripts = $this->get_scripts();
		foreach ( $scripts as $handle => $asset ) {
			$deps = isset( $asset['deps'] ) ? $asset['deps'] : '';
			wp_register_script( $handle, $asset['src'], $deps, $asset['version'], true );
		}

		wp_localize_script( 'contact_form_script', 'a05_cf', [
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'error_msg' => __( 'Something went wrong!', 'a05_contact_form' ),
		] );
	}
}

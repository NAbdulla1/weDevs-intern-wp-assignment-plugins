<?php


namespace A13_Subscription_Form;


class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, "register_scripts" ] );
	}

	public function register_scripts() {
		$scripts = $this->get_scripts();
		foreach ( $scripts as $handle => $asset ) {
			wp_register_script( $handle, $asset['src'], $asset['deps'], $asset['version'], true );
		}
		wp_localize_script( 'a13_subs_form_submit', 'a13sfs', [
			'submit_endpoint' => admin_url() . 'admin-ajax.php',
			'loading_img_src' => A13_SUBSCRIPTION_FORM_ASSETS . "/images/loading.gif",
		] );
	}

	private function get_scripts(): array {
		return array(
			'jquerya13'            => array(
				'src'     => 'https://code.jquery.com/jquery-3.6.0.min.js',
				'version' => '3.6.0',
				'deps'    => []
			),
			'a13_subs_form_submit' => array(
				'src'     => A13_SUBSCRIPTION_FORM_ASSETS . "/js/subscription_form_submit.js",
				'version' => filemtime( A13_SUBSCRIPTION_FORM_PATH . "/assets/js/subscription_form_submit.js" ),
				'deps'    => [ 'jquerya13' ]
			),
		);
	}
}

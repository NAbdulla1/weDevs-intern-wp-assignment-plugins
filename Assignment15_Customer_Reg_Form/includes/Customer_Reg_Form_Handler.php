<?php


namespace A15_Customer_Reg_Form;


class Customer_Reg_Form_Handler {
	public function __construct() {
		add_action( 'admin_post_nopriv_a15_crf_registration_form_action', [ $this, 'handle_reg' ] );
		add_action( 'admin_post_a15_crf_registration_form_action', [ $this, 'handle_reg' ] );
	}

	public function handle_reg() {
		print_r( $_POST );
		$success = false;
		if ( $success ) {
			//todo redirect to login
		} else {
			wp_redirect( home_url( '/a15-customer-reg-form-woeirundflsj?diredteadsfasdf=true' ), 301 );
			exit;
		}
	}
}
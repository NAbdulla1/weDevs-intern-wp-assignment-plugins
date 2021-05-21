<?php


namespace A13_Subscription_Form;


use A13_Subscription_Form\Api\MailChimpClient;
use A13_Subscription_Form\Widgets\Subscription_Form_Widget;

class AjaxHandler {
	public function __construct() {
		$form_action = Subscription_Form_Widget::form_ajax_action;
		add_action( "wp_ajax_$form_action", [ $this, 'handle_form_submission' ] );
		add_action( "wp_ajax_nopriv_$form_action", [ $this, 'handle_form_submission' ] );
	}

	public function handle_form_submission() {
		if ( empty( $_POST['_wpnonce'] ) || wp_verify_nonce( $_POST, Subscription_Form_Widget::form_nonce_action ) ) {
			wp_send_json_error( [ 'message' => 'nonce verification failed' ], 400 );
		}
		if ( empty( $_POST['email'] ) ) {
			wp_send_json_error( [ 'message' => 'no email provided' ], 400 );
		}
		$email = $_POST['email'];
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			wp_send_json_error( [ 'message' => 'invalid email address' ] );
		}

		$resp = MailChimpClient::submitEmailToList( $email );
		if ( ! $resp['success'] ) {
			wp_send_json_error( [ 'message' => $resp['message'] ] );
		}

		$body = $resp['content'];
		if ( $body->error_count > 0 ) {
			wp_send_json_error( [ 'message' => $body->errors[0]->error ] );
		}
		if ( $body->total_updated > 0 ) {
			wp_send_json_success( [ 'message' => 'subscription updated' ] );
		}
		wp_send_json_success( [ 'message' => 'subscription successful' ] );
	}
}

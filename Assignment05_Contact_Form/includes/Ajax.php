<?php


namespace A05_Contact_Form;


class Ajax {
	private array $errors = [];

	public function __construct() {
		add_action( 'wp_ajax_a05_contact_form', [ $this, 'submit_contact_form' ] );
		add_action( 'wp_ajax_nopriv_a05_contact_form', [ $this, 'submit_contact_form' ] );
	}

	public function submit_contact_form() {
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'a05_contact_form__nonce' ) ) {
			wp_send_json_error( [
				'message' => 'Nonce verification failed!',
			] );
		}
		$this->validate_contact_form();
		if ( ! empty( $this->errors ) ) {
			wp_send_json_error( [
				'message' => 'form validation failed',
				'errors'  => $this->errors
			] );
		}

		$insert_id = ( new DB() )->insert( $_POST );
//		$insert_id = a05_contact_form_save_to_db($_POST);

		if ( is_wp_error( $insert_id ) ) {
			wp_send_json_error( [
				'message' => $insert_id->get_error_message()
			] );
		} else {
			wp_send_json_success( [
				'message' => "Your contact request id is $insert_id"
			] );
		}
	}

	public function validate_contact_form(): void {
		if ( empty( $_POST['a05_contact_form_fname'] ) ) {
			$this->errors['first_name'] = 'No first name provided';
		}
		if ( empty( $_POST['a05_contact_form_lname'] ) ) {
			$this->errors['last_name'] = 'No last name provided';
		}
		if ( empty( $_POST['a05_contact_form_email'] ) ) {
			$this->errors['email'] = 'No email provided';
		}
		if ( empty( $_POST['a05_contact_form_message'] ) ) {
			$this->errors['message'] = "No message provided";
		}
	}
}
<?php


namespace A13_Subscription_Form\Api;

use A13_Subscription_Form\Admin\Subscription_Settings_MailChimp;


class MailChimpClient {
	private static string $baseUrl = 'https://us6.api.mailchimp.com/3.0';
	private static string $auth;
	private static bool $initiated = false;

	private static function init() {
		if ( ! self::$initiated ) {
			$api_key         = get_option( Subscription_Settings_MailChimp::mail_api_option );
			self::$auth      = base64_encode( "key:$api_key" );
			self::$initiated = true;
		}
	}

	public static function getMailLists( string $url ) {
		self::init();

		$resp = wp_remote_get( self::$baseUrl . $url, array(
			'headers' => array( 'Authorization' => "Basic " . self::$auth )
		) );
		if ( is_wp_error( $resp ) ) {
			return json_encode( [ 'success' => false, 'message' => $resp->get_error_message() ] );
		}
		if ( wp_remote_retrieve_response_code( $resp ) != 200 ) {
			return json_encode( [ 'success' => false, 'message' => wp_remote_retrieve_response_message( $resp ) ] );
		}

		return json_encode( [ 'success' => true, 'content' => json_decode( wp_remote_retrieve_body( $resp ) ) ] );
	}

	public static function submitEmailToList( $email ) {
		self::init();

		$list_id = get_option( Subscription_Settings_MailChimp::mail_list_id_option );
		if ( ! $list_id ) {
			return [ 'success' => false, 'message' => 'mail list not selected in admin settings' ];
		}
		$resp = wp_remote_post( self::$baseUrl . "/lists/$list_id", array(
			'headers' => array( 'Authorization' => "Basic " . self::$auth ),
			'body'    => json_encode( array(
				'members'         => array(
					array(
						'email_address'    => $email,
						'email_type'       => 'html',
						'status'           => 'subscribed',
						'timestamp_signup' => date( 'c' )
					)
				),
				'update_existing' => true
			) )
		) );
		if ( is_wp_error( $resp ) ) {
			return [ 'success' => false, 'message' => $resp->get_error_message() ];
		}
		if ( wp_remote_retrieve_response_code( $resp ) != 200 ) {
			return [ 'success' => false, 'message' => wp_remote_retrieve_response_message( $resp ) ];
		}

		return [ 'success' => true, 'content' => json_decode( wp_remote_retrieve_body( $resp ) ) ];
	}
}

<?php


namespace A13_Subscription_Form\Api;

use A13_Subscription_Form\Admin\Subscription_Settings_MailChimp;


class MailChimpClient {
	private static string $baseUrl = 'https://us6.api.mailchimp.com/3.0';
	private static string $auth;
	private static bool $initied = false;

	private static function init() {
		$api_key       = get_option( Subscription_Settings_MailChimp::mail_api_option );
		self::$auth    = base64_encode( "key:$api_key" );
		self::$initied = true;
	}

	public static function get( string $url ) {
		if ( ! self::$initied ) {
			self::init();
		}
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
}

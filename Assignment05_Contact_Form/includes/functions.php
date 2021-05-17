<?php
//this file is not working for some unknown reason.
function a05_contact_form_save_to_db( $args = [] ) {//assuming all the data are valid. as we have validated in Ajax.php
	\A05_Contact_Form\Log::dbg( 'inside insert db' );
	$data = [
		'first_name' => $args['a05_contact_form_fname'],
		'last_name'  => $args['a05_contact_form_lname'],
		'email'      => $args['a05_contact_form_email'],
		'message'    => $args['a05_contact_form_message'],
	];
	\A05_Contact_Form\Log::dbg( json_encode( $data ) );

	global $wpdb;
	if ( $wpdb->insert( "{$wpdb->prefix}a05_contact_form", $data, [ "%s", "%s", "%s", "%s" ] ) ) {
		return $wpdb->insert_id;
	}

	return new WP_Error( 'db-error', $wpdb->last_error );
}
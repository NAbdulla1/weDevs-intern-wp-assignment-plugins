<?php

namespace A03_Posts_Email_Notification;

/**
 * Class Email_Notifier
 * @package A03_Posts_Email_Notification\Admin
 */
class Email_Notifier {

	private array $other_user_emails;

	/**
	 * Email_Notifier constructor.
	 */
	public function __construct() {
		$this->other_user_emails = array();
		add_action( 'transition_post_status', [ $this, 'new_post_published' ], 20, 3 );

		add_action( 'a03_add_other_user_email', [ $this, 'add_other_user_emails' ] );//custom hook
	}

	/**
	 * @param $new_status
	 * @param $old_status
	 * @param $post_object
	 */
	public function new_post_published( $new_status, $old_status, $post_object ) {
		if ( $new_status === "publish" && ( $old_status === 'draft' || $old_status === 'auto-draft' ) ) {
			$this->send_email_to_admins( $post_object );
			$this->send_email_to_others( $post_object );
		}
	}

	private function send_email_to_admins( $post_object ) {
		$admins = get_users( "role=Administrator" );
		for ( $i = 0; $i < count( $admins ); $i ++ ) {
			$adm = $admins[ $i ];
			Log::dbg( 'sending email to admin: ' . $adm->user_email );
			//send email to admin
		}
	}

	private function send_email_to_others( $post_object ) {
		foreach ( $this->other_user_emails as $user_email ) {
			Log::dbg( 'sending email to user: ' . $user_email );
			//send email to users
		}
	}

	public function add_other_user_emails( array $emails ) {
		foreach ( $emails as $email ) {
			array_push( $this->other_user_emails, $email );
		}
	}
}

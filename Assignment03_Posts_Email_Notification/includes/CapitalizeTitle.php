<?php


namespace A03_Posts_Email_Notification;


class CapitalizeTitle {

	public function __construct() {
		add_filter( 'the_title', [ $this, 'capitalize' ] );
	}

	public function capitalize( $title ) {
		return ucwords( $title );
	}
}
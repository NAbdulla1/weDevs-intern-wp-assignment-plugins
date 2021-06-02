<?php


namespace A03_Posts_Email_Notification;


/**
 * Class CapitalizeTitle
 * @package A03_Posts_Email_Notification
 */
class CapitalizeTitle {

	/**
	 * CapitalizeTitle constructor.
	 */
	public function __construct() {
		add_filter( 'the_title', [ $this, 'capitalize' ] );
	}

	/**
	 * 'the_title' filter callback
	 *
	 * @param $title
	 *
	 * @return string
	 */
	public function capitalize( $title ) {
		return ucwords( $title );
	}
}
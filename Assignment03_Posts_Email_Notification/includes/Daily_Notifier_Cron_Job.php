<?php


namespace A03_Posts_Email_Notification;


class Daily_Notifier_Cron_Job {
	private function __construct() {
	}

	public static function getInstance() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	public function notify() {
		$summ = $this->summary();

		Log::dbg( "notifying admin with email content. $summ" );
		//do email actually
		wp_mail( get_option( 'admin_email' ), 'Daily Posts Summary', $summ, );

		$timestamp = wp_next_scheduled( 'a03_pen_daily_notifier_hook' );
		Log::dbg( 'next scheduled at ' . date( 'c', $timestamp ) );
	}

	public function startScheduler() {
		$timestamp = strtotime( "today midnight" ) + 1;
		//$timestamp = strtotime( 'now' ) - 24 * 60 * 60 + 30;//time to run after 30 seconds after plugin activation, debugging purpose
		add_action( 'a03_pen_daily_notifier_hook', [ $this, 'notify' ] );
		if ( ! wp_next_scheduled( 'a03_pen_daily_notifier_hook' ) ) {
			wp_schedule_event( $timestamp, 'daily', 'a03_pen_daily_notifier_hook' );
		}
	}

	public function stopScheduler() {
		$timestamp = wp_next_scheduled( 'a03_pen_daily_notifier_hook' );
		Log::dbg( 'scheduler ending... next scheduled ' . date( 'c', $timestamp ) );
		if ( $timestamp !== false ) {
			wp_unschedule_event( $timestamp, 'a03_pen_daily_notifier_hook' );
		}
	}

	private function summary(): string {
		$today     = time();
		$yesterday = $today - 24 * 60 * 60;
		$yesterday = getdate( $yesterday );
		$posts     = get_posts( array(
			'status'     => 'published',
			'date_query' => array(
				'after'     => array(
					'day'   => $yesterday['mday'],
					'month' => $yesterday['mon'],
					'year'  => $yesterday['year'],
				),
				'before'    => array(
					'day'   => $yesterday['mday'],
					'month' => $yesterday['mon'],
					'year'  => $yesterday['year'],
				),
				'inclusive' => true
			)
		) );

		$count         = count( $posts );
		$titles        = array_map( fn( $pst ) => $pst->post_title, $posts );
		$email_content = "Dear Admin,\nYesterday we have total $count posts published.\nThe post titles are here:\n";
		$email_content .= join( "\n", $titles );
		$email_content .= "\nYours Sincerely\nDaily Notifier Plugin\n";

		return $email_content;
	}
}
